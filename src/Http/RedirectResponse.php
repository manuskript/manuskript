<?php

namespace Manuskript\Http;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse as HttpRedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Validator;
use Manuskript\Facades\URL;

final class RedirectResponse implements Responsable
{
    protected ?string $message = null;

    protected ?Validator $validator = null;

    public function __construct(
        protected string $url,
        protected int $status = 302,
        protected array $headers = []
    ) {}

    public static function route(string $route, $params = [], int $status = 302, array $headers = []): self
    {
        return new self(URL::route($route, $params), $status, $headers);
    }

    public static function to(string $url, int $status = 302, array $headers = []): self
    {
        return new self($url, $status, $headers);
    }

    public static function back(int $status = 302, array $headers = []): self
    {
        return self::to(URL::previous(), $status, $headers);
    }

    public function withErrors(Validator $validator): self
    {
        $this->validator = $validator;

        return $this;
    }

    public function withMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function toResponse($request): JsonResponse|HttpRedirectResponse
    {
        if ($request->header('X-MANUSKRIPT-API')) {
            return new JsonResponse([
                'message' => $this->message,
                'errors' => $this->validator->errors(),
            ]);
        }

        return Redirect::to($this->url, $this->status, $this->headers)
            ->with(['message' => $this->message])
            ->withErrors($this->validator);
    }
}

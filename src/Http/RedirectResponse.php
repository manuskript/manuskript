<?php

namespace Manuskript\Http;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse as HttpRedirectResponse;
use Illuminate\Support\Facades\Session;
use Manuskript\Facades\URL;

class RedirectResponse implements Responsable
{
    protected array $flash = [];

    public function __construct(
        protected string $url,
        protected int $status = 302,
        protected array $headers = []
    ) {
    }

    public static function to(string $url, int $status = 302, array $headers = [])
    {
        return new static($url, $status, $headers);
    }

    public static function back(int $status = 302, array $headers = [])
    {
        return static::to(URL::previous(), $status, $headers);
    }

    public function with(array|string $key, $value = null): self
    {
        if (is_array($key)) {
            $this->flash = array_merge($this->flash, $key);
        } else {
            $this->flash[$key] = $value;
        }

        return $this;
    }

    public function toResponse($request)
    {
        if ($request->header('X-MANUSKRIPT-API')) {
            return new JsonResponse($this->flash);
        }

        Session::flash('flash', $this->flash);

        return new HttpRedirectResponse($this->url, $this->status, $this->headers);
    }
}

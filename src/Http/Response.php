<?php

namespace Manuskript\Http;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final class Response implements Responsable
{
    public function __construct(
        private string $component,
        private array $props = []
    ) {}

    public static function make(string $component, array $props = []): self
    {
        return new self($component, $props);
    }

    public function with(array|string $key, $value = null): self
    {
        if (is_array($key)) {
            $this->props = array_merge($this->props, $key);
        } else {
            $this->props[$key] = $value;
        }

        return $this;
    }

    public function toResponse($request): HttpResponse
    {
        if ($request->header('X-MANUSKRIPT-API')) {
            return new JsonResponse($this->props);
        }

        return Inertia::render($this->component, $this->props)
            ->toResponse($request);
    }
}

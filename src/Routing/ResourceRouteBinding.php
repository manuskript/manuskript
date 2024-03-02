<?php

namespace Manuskript\Routing;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Config;
use Manuskript\Manuskript;
use Manuskript\Resource;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResourceRouteBinding
{
    public function __invoke(string $handle, Route $route): string
    {
        if (!$this->isManuskript($route)) {
            return $handle;
        }

        if ($resource = $this->resolveResource($handle)) {
            return $resource;
        }

        throw new NotFoundHttpException();
    }

    protected function resolveResource(string $handle): ?string
    {
        return Manuskript::resolve(
            static fn($resource) => $resource::slug() === $handle
        );
    }

    protected function isManuskript(Route $route): bool
    {
        return $route->getPrefix() === Config::get('manuskript.path', 'manuskript');
    }
}

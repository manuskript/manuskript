<?php

namespace Manuskript\Routing;

use Illuminate\Routing\Route;
use Manuskript\Manuskript;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResourceRouteBinding
{
    public function __invoke(string $handle, Route $route)
    {
        if (!$this->isManuskript($route)) {
            return $handle;
        }

        if ($resource = $this->resolveResource($handle)) {
            return $resource;
        }

        throw new NotFoundHttpException();
    }

    protected function resolveResource(string $handle)
    {
        return Manuskript::resolve(fn ($resource) => $resource::slug() === $handle);
    }

    protected function isManuskript(Route $route)
    {
        return $route->getPrefix() === 'manuskript';
    }
}

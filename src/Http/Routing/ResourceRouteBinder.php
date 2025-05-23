<?php

namespace Manuskript\Http\Routing;

use Illuminate\Routing\Route;
use Manuskript\Resources\Resource;
use Manuskript\Resources\ResourceRepository;

class ResourceRouteBinder
{
    public function __construct(
        private readonly ResourceRepository $resources,
    ) {
    }

    public function bind(string $key, Route $route): string|Resource
    {
        return $this->resources->resolve($key);
    }
}

<?php

namespace Manuskript\Factories;

use Illuminate\Support\Arr;
use InvalidArgumentException;

class ResourceFactory
{
    protected $resources = [];

    public function register(array $resources)
    {
        $this->resources = $resources;
    }

    public function fromModel(string $model)
    {
        return Arr::first(
            $this->resources(),
            fn ($resource) => $resource::$model === $model,
            fn () => throw new InvalidArgumentException($model)
        );
    }

    public function resolve($key)
    {
        return Arr::first(
            $this->resources($key),
            fn ($resource) => (string) $resource::slug() === $key,
            fn () => throw new InvalidArgumentException($key)
        );
    }

    public function resources()
    {
        return $this->resources;
    }
}

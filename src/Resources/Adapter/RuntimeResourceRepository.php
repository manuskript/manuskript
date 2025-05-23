<?php

namespace Manuskript\Resources\Adapter;

use Illuminate\Support\Facades\Auth;
use Manuskript\Resources\Resource;
use Manuskript\Resources\ResourceRepository;

class RuntimeResourceRepository implements ResourceRepository
{
    public function __construct(private readonly RuntimeResourceStorage $storage)
    {
    }

    public function register(Resource $resource): void
    {
        if ($this->storage->has($resource->getKey())) {
            // TODO: Throw Exception
        }

        $this->storage->put($resource->getKey(), $resource);
    }

    public function resolve(string $key): Resource
    {
        return $this->storage->get($key, function () {
            // TODO: Throw Exception
        });
    }
}

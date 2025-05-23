<?php

namespace Manuskript\Facades;

use Illuminate\Support\Facades\Facade;
use Manuskript\Resources\ResourceRepository;

/**
 * @method static void register(\Manuskript\Resources\Resource $resource)
 * @method static \Manuskript\Resources\Resource resolve(string $key)
 */
class Resource extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ResourceRepository::class;
    }
}

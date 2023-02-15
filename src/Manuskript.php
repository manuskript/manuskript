<?php

namespace Manuskript;

use Illuminate\Support\Facades\Facade;
use Manuskript\Factories\ResourceFactory;

class Manuskript extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ResourceFactory::class;
    }
}

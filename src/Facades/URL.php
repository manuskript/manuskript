<?php

namespace Manuskript\Facades;

use Illuminate\Support\Facades\Facade;
use Manuskript\Routing\UrlGenerator;

class URL extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UrlGenerator::class;
    }
}

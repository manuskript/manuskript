<?php

namespace Manuskript\Facades;

use Illuminate\Support\Facades\Facade;
use Manuskript\Menu\Factory;

class Menu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}

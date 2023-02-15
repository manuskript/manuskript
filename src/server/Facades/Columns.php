<?php

namespace Manuskript\Facades;

use Illuminate\Support\Facades\Facade;
use Manuskript\Columns\Repository;

class Columns extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Repository::class;
    }
}

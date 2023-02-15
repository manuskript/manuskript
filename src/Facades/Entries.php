<?php

namespace Manuskript\Facades;

use Illuminate\Support\Facades\Facade;
use Manuskript\Entries\Repository;

class Entries extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Repository::class;
    }
}

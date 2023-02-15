<?php

namespace Manuskript\Tests\stubs\Resources;

use Manuskript\Resource;
use Manuskript\Tests\stubs\Models\Bar;
use Manuskript\Tests\stubs\Policies\BarPolicy;

class BarResource extends Resource
{
    public static string $model = Bar::class;

    protected static ?string $policy = BarPolicy::class;
}

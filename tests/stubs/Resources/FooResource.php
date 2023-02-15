<?php

namespace Manuskript\Tests\stubs\Resources;

use Manuskript\Fields\Id;
use Manuskript\Resource;
use Manuskript\Tests\stubs\Models\Foo;

class FooResource extends Resource
{
    public static string $model = Foo::class;

    public static function fields(): array
    {
        return [
            Id::make(),
        ];
    }
}

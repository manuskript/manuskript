<?php

namespace Manuskript\Tests;

use Manuskript\Manuskript;
use Manuskript\Tests\stubs\Resources\BarResource;
use Manuskript\Tests\stubs\Resources\FooResource;

class ResourceRegistrationTest extends TestCase
{
    public function test_it_registers_resources()
    {
        Manuskript::register(['A', 'B']);
        $this->assertEquals(['A', 'B'], Manuskript::resources());

        Manuskript::register('C');
        $this->assertEquals(['A', 'B', 'C'], Manuskript::resources());

        Manuskript::register(fn($request) => 'D');
        $this->assertEquals(['A', 'B', 'C', 'D'], Manuskript::resources());
    }

    public function test_it_resolves_resources()
    {
        Manuskript::$resources = [
            FooResource::class,
            BarResource::class,
        ];

        $resolved = Manuskript::resolve(fn($resource) => $resource::slug() === 'bar');

        $this->assertEquals(BarResource::class, $resolved);
    }

    public function reset()
    {
        Manuskript::$resources = [];
    }
}

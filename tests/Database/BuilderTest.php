<?php

namespace Manuskript\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Manuskript\Database\Collection;
use Manuskript\Database\Resource;
use Manuskript\Manuskript;
use Manuskript\Tests\stubs\Models\Foo;
use Manuskript\Tests\stubs\Resources\FooResource;

class BuilderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->refreshDatabase();

        Manuskript::register(FooResource::class);
    }

    public function test_it_creates_a_new_resource()
    {
        FooResource::query()->create();

        $this->assertCount(1, FooResource::query()->get());
    }

    public function test_it_fetches_a_single_resource()
    {
        $resource = new Resource(Foo::create()->fresh(), 'show');

        $this->assertEquals($resource, FooResource::query()->context('show')->find(1));
    }


    public function test_it_fetches_all_resources()
    {
        $resources = new Collection([
            new Resource(Foo::create()->fresh(), 'index'),
            new Resource(Foo::create()->fresh(), 'index'),
        ]);

        $this->assertEquals($resources, FooResource::query()->context('index')->get());
    }

    public function test_it_fetches_paginated_resources()
    {
        $resources = new Collection([
            new Resource(Foo::create()->fresh(), 'index'),
            new Resource(Foo::create()->fresh(), 'index'),
        ]);

        $paginator = FooResource::query()->context('index')->paginate(10);

        $this->assertEquals($resources, $paginator->getCollection());
    }
}

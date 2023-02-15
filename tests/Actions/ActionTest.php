<?php

namespace Manuskript\Tests\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Manuskript\Actions\Destroy;
use Manuskript\Database\Collection;
use Manuskript\Database\Resource;
use Manuskript\Tests\stubs\Models\Foo;
use Manuskript\Tests\TestCase;

class ActionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->refreshDatabase();
    }

    public function test_it_handles_actions()
    {
        $action = new Destroy();

        $resource = new Resource(Foo::create(), 'show');
        $this->assertCount(1, Foo::all());

        $action($resource);
        $this->assertCount(0, Foo::all());
    }

    public function test_it_handles_batch_actions()
    {
        $action = new Destroy();

        $collection = new Collection([
            new Resource(Foo::create(), 'show'),
            new Resource(Foo::create(), 'show'),
        ]);
        $this->assertCount(2, Foo::all());

        $action($collection);
        $this->assertCount(0, Foo::all());
    }
}

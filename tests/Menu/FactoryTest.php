<?php

namespace Manuskript\Tests\Menu;

use InvalidArgumentException;
use Manuskript\Facades\Menu as Facade;
use Manuskript\Facades\URL;
use Manuskript\Menu\Factory;
use Manuskript\Menu\Item;
use Manuskript\Menu\Menu;
use Manuskript\Support\Collection;
use Manuskript\Tests\stubs\Resources\BarResource;
use Manuskript\Tests\stubs\Resources\FooResource;
use Manuskript\Tests\TestCase;

class FactoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Facade::clear();
    }

    public function test_it_is_resolveable_from_its_facade()
    {
        $this->assertTrue(Facade::getFacadeRoot() instanceof Factory);
    }

    public function test_it_creates_a_menu_from_items()
    {
        $factory = new Factory();

        $items = [new Item('Foo', 'foo')];

        $this->assertEquals($items, $factory->make('Baz', $items)->getItems());
        $this->assertEquals($items, $factory->make('Baz', [['Foo', 'foo']])->getItems());
        $this->assertEquals($items, $factory->make('Baz', [['label' => 'Foo', 'url' => 'foo']])->getItems());
    }

    public function test_it_validates_the_input()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('$items[] must be of type array, string given');

        $factory = new Factory();

        $factory->make('Baz', ['Foo', 'foo']);
    }

    public function test_it_creates_menu_items_from_an_array()
    {
        $expected = new Item('Foo', 'foo');

        $factory = new Factory();

        $this->assertEquals($expected, $factory->makeItem(['label' => 'Foo', 'url' => 'foo']));
        $this->assertEquals($expected, $factory->makeItem(['url' => 'foo', 'label' => 'Foo']));
        $this->assertEquals($expected, $factory->makeItem(['Foo', 'foo']));
    }

    public function test_it_creates_menus_from_resources()
    {
        $expected = Collection::make([
            new Menu('Menu', [
                new Item('Foo', fn () => URL::route('resources.index', FooResource::slug())),
                new Item('Bar', fn () => URL::route('resources.index', BarResource::slug())),
            ])
        ]);

        $factory = new Factory();

        $menus = $factory->fromResources([
            FooResource::class,
            BarResource::class,
        ]);

        $this->assertEquals($expected, $menus);
        $this->assertEquals($expected->all(), $factory::registered());
    }
}

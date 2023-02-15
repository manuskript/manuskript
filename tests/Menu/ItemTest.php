<?php

namespace Manuskript\Tests\Menu;

use Illuminate\Http\Request;
use Manuskript\Menu\Item;
use Manuskript\Tests\TestCase;

class ItemTest extends TestCase
{
    public function test_it_handles_its_active_state()
    {
        $request = Request::create('foo');

        $item = new Item('Foo', 'foo');
        $this->assertTrue($item->isActive($request));

        $item = new Item('Foo', '/foo');
        $this->assertTrue($item->isActive($request));

        $item = new Item('Foo', 'http://localhost/foo');
        $this->assertTrue($item->isActive($request));

        $item = new Item('Foo', 'bar');
        $this->assertFalse($item->isActive($request));
    }

    public function test_it_omits_query_parameters_by_retrieving_the_active_state()
    {
        $request = Request::create('foo', 'GET', ['foo' => 'bar']);

        $item = new Item('Foo', 'foo');
        $this->assertTrue($item->isActive($request));
    }

    public function test_it_handles_external_urls()
    {
        $item = new Item('Foo', 'https://manuskript.dev/docs');

        $this->assertEquals('https://manuskript.dev/docs', $item->url());
    }

    public function test_it_is_json_serializable()
    {
        $item = new Item('Foo', 'foo');

        $this->assertEquals($item->jsonSerialize(), [
            'label' => 'Foo',
            'url' => $item->url(),
            'active' => false,
        ]);
    }
}

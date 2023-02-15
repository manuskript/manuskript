<?php

namespace Manuskript\Tests;

use Manuskript\Tests\stubs\Filters\FooFilter;

class FilterTest extends TestCase
{
    public function test_it_is_json_serializable()
    {
        $filter = new FooFilter();

        $this->assertEquals([
            'name' => md5(FooFilter::class),
            'label' => 'FooFilter',
            'active' => false,
        ], $filter->jsonSerialize());
    }

    public function test_it_toogles_its_active_state_based_on_the_request()
    {
        $filter = new FooFilter();

        $this->assertFalse($filter->isActive());

        request()->merge(['filter' => [$filter->name()]]);

        $this->assertTrue($filter->isActive());
    }
}

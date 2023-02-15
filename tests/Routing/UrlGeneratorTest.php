<?php

namespace Manuskript\Tests\Routing;

use Manuskript\Facades\URL;
use Manuskript\Tests\TestCase;

class UrlGeneratorTest extends TestCase
{
    public function test_it_generates_urls_by_route_name()
    {
        $this->assertEquals('/manuskript', URL::route('dashboard'));
    }
}

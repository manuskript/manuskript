<?php

namespace Manuskript\Tests;

use Illuminate\Http\Request;
use Manuskript\Http\Middleware\Authorize;
use Manuskript\Manuskript;
use Manuskript\Tests\stubs\Resources\BarResource;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AuthorizationTest extends TestCase
{
    public function test_access_is_forbidden()
    {
        $request = Request::create('/manuskript');

        $this->assertFalse(Manuskript::check($request));

        Manuskript::auth(fn () => true);
        $this->assertTrue(Manuskript::check($request));
    }

    public function test_authorization_middleware()
    {
        $this->expectException(AccessDeniedHttpException::class);

        Manuskript::auth(fn () => false);

        $request = Request::create('/manuskript');
        (new Authorize())->handle($request, function ($request) {
            $this->fail();
        });
    }

    public function test_it_handles_policies()
    {
        $this->assertTrue(Manuskript::can('view', BarResource::class));

        $this->assertFalse(Manuskript::can('delete', BarResource::class));
    }
}

<?php

namespace Manuskript\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Manuskript\Menu\Factory as Menu;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'manuskript::manuskript';

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [

            'message' => function () use ($request) {
                return $request->session()->get('message', null);
            },

            'menus' => function () {
                return Menu::registered();
            },

            //
        ]);
    }
}

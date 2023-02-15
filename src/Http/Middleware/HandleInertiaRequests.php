<?php

namespace Manuskript\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Manuskript\Facades\Menu;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'manuskript::manuskript';

    public function share(Request $request)
    {
        return array_merge(parent::share($request), [

            'menus' => function () {
                return Menu::registered();
            },

            //
        ]);
    }
}

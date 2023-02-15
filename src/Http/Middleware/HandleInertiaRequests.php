<?php

namespace Manuskript\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Middleware;
use Manuskript\Manuskript;
use Manuskript\Nav\NavItem;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'manuskript::manuskript';

    public function share(Request $request)
    {
        return [
            'nav' => fn () => Collection::make(array_map(
                fn ($resource) => new NavItem($resource),
                Manuskript::resources()
            ))->groupBy(fn ($item) => $item->group()),

            'toast' => fn () => $request->session()->get('toast'),
        ];
    }
}

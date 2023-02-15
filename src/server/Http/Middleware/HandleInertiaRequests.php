<?php

namespace Manuskript\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Manuskript\Manuskript;
use Manuskript\Nav\NavItem;
use Manuskript\Support\Collection;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'manuskript::manuskript';

    public function version(Request $request)
    {
        return md5(Manuskript::version());
    }

    public function handle(Request $request, Closure $next)
    {
        $this->handleExceptions();

        return parent::handle($request, $next);
    }

    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'base' => fn () => config('manuskript.path'),
            'app' => fn () => [
                'version' => fn () => $this->version($request),
                'locale' => fn () => app()->getLocale(),
                'name' => config('app.name', 'Manuskript'),
            ],
            'nav' => fn () => Collection::make(Manuskript::resources())
                ->filter(fn ($resource) => $resource::showInMenu() && Manuskript::can('viewAny', $resource))
                ->map(fn ($resource) => new NavItem($resource))
                ->groupBy(fn ($item) => $item->group()),

            'toast' => fn () => $request->session()->get('toast'),

            'error' => fn () => $request->session()->get('error'),
        ]);
    }

    protected function handleExceptions(): void
    {
        //
    }
}

<?php

namespace Manuskript;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Manuskript\Columns\Repository as ColumnsRepository;
use Manuskript\Entries\Repository as EntriesRepository;
use Manuskript\Factories\NavFactory;
use Manuskript\Factories\ResourceFactory;
use Manuskript\Http\Middleware\HandleInertiaRequests;
use Manuskript\Http\Request;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->app->register(InertiaServiceProvider::class);

        $this->app->bind(EntriesRepository::class);
        $this->app->bind(ColumnsRepository::class);

        $this->app->singleton(NavFactory::class);
        $this->app->singleton(ResourceFactory::class);
        $this->app->singleton(Request::class, fn () => Request::capture());
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        $this->loadViewsFrom(__DIR__.'/../views', 'manuskript');

        $this->publishes([
            __DIR__.'/../.manuskript/dist' => public_path('vendor/manuskript'),
        ], 'manuskript');

        Route::bind('resource', function ($handle, $route) {
            if ($route->getPrefix() !== 'manuskript') {
                return $handle;
            }

            return $this->app->make(ResourceFactory::class)->resolve($handle);
        });

        $this->registerMiddlewareGroups();
    }

    protected function registerMiddlewareGroups()
    {
        $router = $this->app->make(Router::class);

        $router->middlewareGroup('manuskript', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            HandleInertiaRequests::class,
        ]);
    }
}

<?php

namespace Manuskript;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Manuskript\Http\Middleware\Authorize;
use Manuskript\Http\Middleware\HandleInertiaRequests;
use Manuskript\Routing\ResourceRouteBinding;
use Manuskript\Routing\UrlGenerator;
use Tightenco\Ziggy\ZiggyServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->configure();
        $this->configurePublishing();
        $this->registerServices();
    }

    public function boot(): void
    {
        $this->registerViews();
        $this->registerRouteBindings();
        $this->registerWebRoutes();
    }

    protected function configure(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/manuskript.php',
            'manuskript'
        );

        config('ziggy.groups.manuskript', [config('manuskript.path') . '.*']);
    }

    protected function configurePublishing(): void
    {
        $this->publishes([
            __DIR__ . '/../public/' => public_path('vendor/manuskript'),
        ], 'manuskript-assets');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/manuskript.php' => config_path('manuskript.php'),
            ], 'manuskript-config');

            // $this->publishes([
            //     __DIR__ . '/../../stubs/provider.stub' => app_path('Providers/ManuskriptServiceProvider.php'),
            // ], 'manuskript-provider');
        }
    }

    protected function registerServices(): void
    {
        $this->app->register(InertiaServiceProvider::class);
        $this->app->register(ZiggyServiceProvider::class);

        $this->app->bind(UrlGenerator::class);
    }

    protected function registerRouteBindings(): void
    {
        Route::bind('resource', new ResourceRouteBinding());
    }

    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'manuskript');
    }

    protected function registerWebRoutes(): void
    {
        Route::group([
            'prefix' => config('manuskript.path'),
            'middleware' => array_merge(config('manuskript.middleware'), [
                Authorize::class,
                HandleInertiaRequests::class,
            ]),
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }
}

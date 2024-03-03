<?php

namespace Manuskript;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Manuskript\Console\Commands;
use Manuskript\Http\Middleware\Authorize;
use Manuskript\Http\Middleware\HandleInertiaRequests;
use Manuskript\Routing\ResourceRouteBinding;
use Manuskript\Routing\UrlGenerator;
use Tightenco\Ziggy\ZiggyServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    private array $commands = [
        Commands\MakeResourceCommand::class,
    ];

    public function register(): void
    {
        $this->configure();
        $this->registerServices();
    }

    public function boot(): void
    {
        $this->registerViews();
        $this->registerRouteBindings();
        $this->registerWebRoutes();
    }

    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/manuskript.php',
            'manuskript'
        );

        config('ziggy.groups.manuskript', [config('manuskript.path') . '.*']);
    }

    protected function configurePublishing()
    {
        $this->publishes([
            __DIR__ . '/../public/' => public_path('vendor/manuskript'),
        ], 'manuskript-assets');

        if ($this->app->runningInConsole()) {

            $this->commands($this->commands);

            $this->publishes([
                __DIR__ . '/../config/manuskript.php' => config_path('manuskript.php'),
            ], 'manuskript-config');

            // $this->publishes([
            //     __DIR__ . '/../../stubs/provider.stub' => app_path('Providers/ManuskriptServiceProvider.php'),
            // ], 'manuskript-provider');
        }
    }

    protected function registerServices()
    {
        $this->app->register(InertiaServiceProvider::class);
        $this->app->register(ZiggyServiceProvider::class);

        $this->app->bind(UrlGenerator::class);
    }

    protected function registerRouteBindings()
    {
        Route::bind('resource', new ResourceRouteBinding());
    }

    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'manuskript');
    }

    protected function registerWebRoutes()
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

<?php

namespace Manuskript;

use Illuminate\Support\Facades\Route;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Manuskript\Exceptions\UnresolvableResourceException;
use Manuskript\Http\Middleware\HandleInertiaRequests;
use Manuskript\Http\Request;
use Manuskript\Routing\UrlGenerator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tightenco\Ziggy\ZiggyServiceProvider;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->configure();
        $this->registerServices();
    }

    public function boot()
    {
        $this->registerRoutes();
        $this->registerViews();
        $this->registerCommands();
        $this->configurePublishing();
    }

    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/manuskript.php',
            'manuskript'
        );

        config('ziggy.groups.manuskript', [config('manuskript.path') . '.*']);
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\InstallCommand::class,
                Console\PolicyCommand::class,
                Console\ResourceCommand::class,
            ]);
        }
    }

    protected function registerRoutes()
    {
        Route::group([
            'prefix' => config('manuskript.path'),
            'middleware' => array_merge(
                config('manuskript.middleware'),
                [HandleInertiaRequests::class]
            ),
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        });

        Route::bind('resource', function ($handle, $route) {
            if ($route->getPrefix() === config('manuskript.path')) {
                try {
                    return Manuskript::resolve($handle);
                } catch (UnresolvableResourceException $e) {
                    throw new NotFoundHttpException('Resource not found.', $e);
                }
            }

            return $handle;
        });
    }

    protected function registerServices()
    {
        $this->app->register(InertiaServiceProvider::class);
        $this->app->register(ZiggyServiceProvider::class);

        $this->app->bind(Entries\Repository::class);
        $this->app->bind(Columns\Repository::class);
        $this->app->bind(UrlGenerator::class);

        $this->app->singleton(Files\Repository::class, function ($app) {
            return new Files\Repository($app->make('filesystem'));
        });

        $this->app->singleton(Request::class, function () {
            return Request::capture();
        });
    }

    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../../views', 'manuskript');
    }

    protected function configurePublishing()
    {
        $this->publishes([
            __DIR__ . '/../../dist' => public_path('vendor/manuskript'),
        ], 'manuskript-assets');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/manuskript.php' => config_path('manuskript.php'),
            ], 'manuskript-config');

            $this->publishes([
                __DIR__ . '/../../stubs/provider.stub' => app_path('Providers/ManuskriptServiceProvider.php'),
            ], 'manuskript-provider');
        }
    }
}

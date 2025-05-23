<?php

namespace Manuskript;

use Illuminate\Contracts\Foundation\CachesRoutes;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    public function register(): void
    {
        $this->configure();
        $this->registerServices();
    }

    private function configure(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/manuskript.php',
            'manuskript'
        );
    }

    private function registerServices(): void
    {
        foreach ([
            Entries\EntryRepository::class => Entries\Adapters\EloquentEntryRepository::class,
            Resources\ResourceRepository::class => Resources\Adapter\RuntimeResourceRepository::class,
        ] as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }

    public function boot(): void
    {
        $this->registerRoutes();
    }

    private function registerRoutes(): void
    {
        Route::bind('resource', Http\Routing\ResourceRouteBinder::class);

        if ($this->app instanceof CachesRoutes && $this->app->routesAreCached()) {
            return;
        }

        Route::group([
            'prefix' => config('manuskript.path'),
            'middleware' => config('manuskript.middleware', 'web'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }
}

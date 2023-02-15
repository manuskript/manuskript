<?php

namespace Manuskript\Tests;

use Manuskript\ServiceProvider;
use Manuskript\Testing\Concerns\InteractsWithResources;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use InteractsWithResources;

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
    }
}

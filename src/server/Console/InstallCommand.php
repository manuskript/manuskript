<?php

namespace Manuskript\Console;

use Manuskript\Support\Str;

class InstallCommand extends Command
{
    protected $signature = 'manuskript:install';

    protected $description = 'Install the Manuskript resources';

    public function handle(): void
    {
        $namespace = $this->getApplicationNamespace();

        $this->comment('Publishing Service Provider...');
        $this->callSilent('vendor:publish', ['--tag' => 'manuskript-provider']);

        $this->namespaceManuskriptServiceProvider($namespace);

        $this->comment('Publishing Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'manuskript-assets']);

        $this->comment('Publishing Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'manuskript-config']);

        $this->info('Manuskript scaffolding installed successfully.');

        if ($this->confirm('Do you wish to register the "ManuskriptServiceProvider"?', true)) {
            $this->registerManuskriptServiceProvider($namespace);
        }
    }

    protected function namespaceManuskriptServiceProvider($namespace): void
    {
        file_put_contents(app_path('Providers/ManuskriptServiceProvider.php'), str_replace(
            "namespace __NAMESPACE__\Providers;",
            "namespace {$namespace}\Providers;",
            file_get_contents(app_path('Providers/ManuskriptServiceProvider.php'))
        ));
    }

    protected function registerManuskriptServiceProvider($namespace): void
    {
        $appConfig = file_get_contents(config_path('app.php'));

        if (Str::contains($appConfig, $namespace . '\\Providers\\ManuskriptServiceProvider::class')) {
            return;
        }

        file_put_contents(config_path('app.php'), str_replace(
            "{$namespace}\\Providers\RouteServiceProvider::class," . PHP_EOL,
            "{$namespace}\\Providers\RouteServiceProvider::class," . PHP_EOL . "        {$namespace}\Providers\ManuskriptServiceProvider::class," . PHP_EOL,
            $appConfig
        ));
    }
}

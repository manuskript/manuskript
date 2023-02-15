<?php

namespace Manuskript\Console;

class ResourceCommand extends Command
{
    protected $signature = 'manuskript:resource {model?}';

    protected $description = 'Create a Manuskript resource';

    public function handle(): void
    {
        $model = $this->argument('model') ?? $this->ask('What is the represented model?');

        $rootNamespace = $this->getApplicationNamespace();
        $modelNamespace = $this->getModelNamespace($rootNamespace);

        if (!is_dir(app_path('Manuskript/Resources'))) {
            mkdir(app_path('Manuskript/Resources'), 0777, true);
        }

        file_put_contents(
            app_path('Manuskript/Resources/' . $model . 'Resource.php'),
            str_replace(
                ['__NAMESPACE__', '__MODEL_NAMESPACE__', '__NAME__'],
                [$rootNamespace, $modelNamespace, $model],
                file_get_contents($this->stubPath('resource.stub'))
            )
        );

        $this->info($model . 'Resource successfully created.');
    }

    protected function getModelNamespace($rootNamespace): string
    {
        return is_dir(app_path('Models')) ? $rootNamespace . '\\Models' : $rootNamespace;
    }
}

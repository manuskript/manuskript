<?php

namespace Manuskript\Console\Commands;

use Manuskript\Support\Str;
use ReflectionClass;
use ReflectionException;

class MakeResourceCommand extends MakeCommand
{
    protected $signature = 'manuskript:make:resource {model : The name of the Eloquent model}';

    protected $description = 'Create a new Manuskript resource class';

    public function handle(): void
    {
        $model = $this->reflectModel();

        $namespace = $this->applicationNamespace('Manuskript\\Resources');
        $className = $model->getShortName() . 'Resource';

        $class = $this->buildClass(__DIR__ . '/stubs/resource.stub', [
            '{{ namespace }}' => $namespace,
            '{{ model_namespace }}' => $model->getName(),
            '{{ class }}' => $className,
            '{{ model }}' => $model->getShortName(),
        ]);

        $this->storeClass("{$namespace}\\{$className}", $class);
    }

    private function reflectModel(): ReflectionClass
    {
        try {
            return new ReflectionClass(
                $this->qualifiedModelNamespace()
            );
        } catch (ReflectionException $e) {
            $this->error($e->getMessage());

            exit;
        }
    }

    private function qualifiedModelNamespace(): string
    {
        $model = ltrim($this->argument('model'), '\\/');

        $model = str_replace('/', '\\', $model);

        if (Str::startsWith($model, $this->applicationNamespace())) {
            return $model;
        }

        return is_dir(app_path('Models'))
            ? $this->applicationNamespace('Models\\' . $model)
            : $this->applicationNamespace($model);
    }
}

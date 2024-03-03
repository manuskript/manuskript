<?php

namespace Manuskript\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Manuskript\Support\Str;

abstract class MakeCommand extends Command
{
    public function __construct(private readonly Filesystem $filesystem)
    {
        parent::__construct();
    }

    protected function applicationNamespace(string $class = ''): string
    {
        return $this->laravel->getNamespace() . $class;
    }

    protected function buildClass(string $stubPath, array $values): string
    {
        $stub = $this->getStub($stubPath);

        $this->fillStub($stub, $values);

        return $stub;
    }

    protected function storeClass(string $namespace, string $content): void
    {
        $path = $this->getPath($namespace);

        if($this->fileExists($path)) {
            $this->error(sprintf('Class "%s" already exists.', $namespace));

            exit;
        }

        if (! $this->filesystem->isDirectory(dirname($path))) {
            $this->filesystem->makeDirectory(dirname($path), 0o777, true, true);
        }

        if($this->filesystem->put($path, $content)) {
            $this->info(sprintf('Class "%s" successfully created.', $namespace));
        } else {
            $this->error(sprintf('Could not create class "%s".', $namespace));
        }
    }

    private function fileExists($path): bool
    {
        return $this->filesystem->exists($path);
    }

    private function getPath(string $name): string
    {
        $name = Str::replaceFirst($this->applicationNamespace(), '', $name);

        return app_path(str_replace('\\', '/', $name) . '.php');
    }

    private function getStub(string $path): string
    {
        return $this->filesystem->get($path);
    }

    private function fillStub(&$stub, array $values): void
    {
        $search = [];
        $replace = [];

        foreach($values as $key => $value) {
            $search[] = $key;
            $replace[] = $value;
        }

        $stub = str_replace($search, $replace, $stub);
    }
}

<?php

namespace Manuskript\Console;

use Manuskript\Support\Str;

class Command extends \Illuminate\Console\Command
{
    protected function getApplicationNamespace(): string
    {
        return Str::replaceLast('\\', '', $this->laravel->getNamespace());
    }

    protected function stubPath($path)
    {
        return __DIR__ . '/../../../stubs/' . $path;
    }
}

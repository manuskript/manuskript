<?php

namespace Manuskript\Files;

use Illuminate\Container\Container;
use Manuskript\Support\Collection;
use Manuskript\Support\Str;

class Repository
{
    public function __construct(
        protected $files
    ) {
    }

    public function parent($path)
    {
        if (Str::contains($path, '/')) {
            return Str::before($path, '/');
        }
    }

    public function files($path = null, $disk = null)
    {
        $files = $this->disk($disk)->listContents($path ?? '/', false);

        return Collection::make(is_array($files) ? $files : $files->toArray())
            ->map(function ($attrs) {
                return array_merge([
                    'type' => $attrs->type(),
                    'path' => $attrs->path(),
                    'last_modified' => $attrs->lastModified(),
                ], pathinfo($attrs['path']));
            })->groupBy('type');
    }

    protected function disk($disk)
    {
        return $this->files->disk($disk ?? config('manuskript.filesystem'));
    }
}

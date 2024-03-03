<?php

namespace Manuskript\Filesystem;

use JsonSerializable;
use Manuskript\Contracts\Arrayable;
use Manuskript\Facades\URL;
use Manuskript\Support\Arr;
use Manuskript\Support\Str;

class Directory implements Arrayable, JsonSerializable
{
    public function __construct(
        private readonly ?string $path,
        private readonly ?string $rootPath,
        private readonly Collection $directories,
        private readonly Collection $files,
    ) {}

    public function url(): string
    {
        return URL::route('assets.index', [
            'folder' => $this->path,
        ]);
    }

    public function breadcrumbs(): array
    {
        $breadcrumbs = [
            [
                'url' => URL::route('assets.index'),
                'label' => $this->getRootPathName(),
            ],
        ];

        if(! is_string($this->path)) {
            return $breadcrumbs;
        }

        $segments = [];

        foreach($this->getPathSegments() as $label) {
            $segments[] = $label;

            $url = URL::route('assets.index', ['folder' => implode('/', $segments)]);

            $breadcrumbs[] = compact('label', 'url');
        }

        return $breadcrumbs;
    }

    private function getRootPathName(): string
    {
        if(empty($this->rootPath)) {
            return 'Disk';
        }

        return Arr::last(explode('/', $this->rootPath));
    }

    private function getPathSegments(): array
    {
        $path = is_string($this->rootPath)
            ? Str::after($this->path, $this->rootPath)
            : $this->path;

        return explode('/', trim($path, '/'));
    }

    public function directories(): Collection
    {
        return $this->directories;
    }

    public function files(): Collection
    {
        return $this->files;
    }

    public function toArray(): array
    {
        return [
            'path' => $this->path,
            'url' => $this->url(),
            'breadcrumbs' => $this->breadcrumbs(),
            'files' => $this->files,
            'directories' => $this->directories,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}

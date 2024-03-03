<?php

namespace Manuskript\Filesystem;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Contracts\Filesystem\Filesystem;
use Manuskript\Exceptions\FileNotFoundHttpException;
use Manuskript\Support\Str;

class Builder
{
    private Filesystem $filesystem;

    public function __construct(
        private readonly Factory $factory,
        private readonly Config $config,
    ) {
        $this->filesystem = $factory->disk(
            $config->get('manuskript.filesystem.disk')
        );
    }

    public function getDirectory(?string $path): Directory
    {
        $path = $this->getValidatedPath($path);

        return new Directory(
            path: $path,
            rootPath: $this->getEntryPath(),
            directories: $this->directories($path),
            files: $this->files($path),
        );
    }

    public function directories(?string $path)
    {
        $path = $this->getValidatedPath($path);

        return $this->transformCollection(
            $this->filesystem->directories($path)
        );
    }

    public function files(?string $path)
    {
        $path = $this->getValidatedPath($path);

        return $this->transformCollection(
            $this->filesystem->files($path)
        );
    }

    private function getValidatedPath(?string $path): ?string
    {
        $entryPath = $this->getEntryPath();

        if(empty($path)) {
            return $entryPath;
        }

        $path = trim($path);

        if(empty($entryPath) || $path === $entryPath) {
            return $path;
        }

        if(Str::startsWith($path, $entryPath . '/')) {
            return $path;
        }

        throw new FileNotFoundHttpException();
    }

    private function getEntryPath(): ?string
    {
        $entryPath = $this->config->get('manuskript.filesystem.folder');

        if(! is_null($entryPath)) {
            $entryPath = trim($entryPath);
        }

        return $entryPath;
    }

    private function transformCollection(array|string $items): Collection
    {
        $items = is_array($items) ? $items : [$items];

        return new Collection(
            array_map(static fn(string $path) => static::transform($path), $items)
        );
    }

    private static function transform(string $path): Resource
    {
        return new Resource($path);
    }
}

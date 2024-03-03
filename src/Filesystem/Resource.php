<?php

namespace Manuskript\Filesystem;

use JsonSerializable;
use Manuskript\Contracts\Arrayable;
use Manuskript\Facades\URL;
use Manuskript\Support\Arr;

class Resource implements Arrayable, JsonSerializable
{
    public function __construct(
        private readonly string $path,
    ) {}

    public function name(): string
    {
        $segments = explode('/', $this->path);

        return Arr::last($segments);
    }

    public function url(): string
    {
        return URL::route('assets.index', [
            'folder' => $this->path,
        ]);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name(),
            'path' => $this->path,
            'url' => $this->url(),
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}

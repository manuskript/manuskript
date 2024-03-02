<?php

namespace Manuskript\Database;

use Illuminate\Database\Eloquent\Model;
use JsonSerializable;
use Manuskript\Contracts\Arrayable;
use Manuskript\Facades\URL;
use Manuskript\Manuskript;
use Manuskript\Support\Collection;

class Resource implements Arrayable, JsonSerializable
{
    protected $resource;

    public function __construct(
        protected Model $model,
        protected string $context
    ) {
        $this->resource =  Manuskript::resolve(
            fn($resource) => $resource::$model === $this->model::class
        );
    }

    public function fields(): Collection
    {
        return $this->resource::fieldsByContext($this->context)
            ->hydrate($this->model);
    }

    public function url(): string
    {
        $route = 'resources.show';

        if(Manuskript::can('update', $this->resource)) {
            $route = 'resources.edit';
        }

        return $this->getUrl($route);
    }

    public function getUrl($route): string
    {
        return URL::route($route, [
            'resource' => $this->resource::slug(),
            'model' => $this->model->getKey(),
        ]);
    }

    public function __get($name): mixed
    {
        return $this->model->$name;
    }

    public function __call($method, $args): mixed
    {
        return call_user_func([$this->model, $method], ...$args);
    }

    public function toArray(): array
    {
        return [
            'key' => $this->model->getKey(),
            'fields' => $this->fields()->values()->toArray(),
            'url' => $this->url(),
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}

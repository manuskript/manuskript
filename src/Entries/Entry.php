<?php

namespace Manuskript\Entries;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;
use JsonSerializable;

class Entry implements Arrayable, JsonSerializable
{
    protected ?array $fields;

    protected mixed $key;

    protected ?string $url;

    public function __construct(string $resource, Model $model, array $fields = null)
    {
        $this->boot($resource, $model, $fields);
    }

    private function boot(string $resource, Model $model, $fields)
    {
        $this->registerFields($resource, $fields);
        $this->registerUrl($resource, $model);
        $this->fill($model);

        $this->key = $model->getKey();
    }

    private function registerUrl($resource, $model)
    {
        $route = $resource::handlesSoftDeletes() && $model->trashed()
            ? 'manuskript.entries.trash.show'
            : 'manuskript.entries.edit';

        $this->url = URL::route($route, [
            'resource' => $resource::slug(),
            'model' => $model->getKey(),
        ]);
    }

    private function registerFields($resource, $register)
    {
        $fields = Collection::make($resource::fields())
            ->when($register, fn ($collection) => $collection->filter(
                fn ($field) => in_array($field->getName(), $register)
            ))->values()->all();

        $this->fields = $fields;
    }

    private function fill($model)
    {
        foreach ($this->fields as $field) {
            $field->hydrate($model);
        }
    }

    public function fields()
    {
        return $this->fields;
    }

    public function toArray()
    {
        return [
            'key' => $this->key,
            'url' => $this->url,
            'fields' => $this->fields,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}

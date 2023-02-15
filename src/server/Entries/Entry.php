<?php

namespace Manuskript\Entries;

use Illuminate\Database\Eloquent\Model;
use JsonSerializable;
use Manuskript\Contracts\Arrayable;
use Manuskript\Facades\URL;
use Manuskript\Manuskript;
use Manuskript\Support\Collection;

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
        $this->url = URL::route($this->getRoute($resource, $model), [
            'resource' => $resource::slug(),
            'model' => $model->getKey(),
        ]);
    }

    private function getRoute($resource, $model)
    {
        if ($resource::handlesSoftDeletes() && $model->trashed()) {
            return 'entries.trash.show';
        }

        return Manuskript::can('update', $resource) ? 'entries.edit' : 'entries.show';
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

<?php

namespace Manuskript\Entries\Adapters;

use Illuminate\Database\Eloquent\Model;
use Manuskript\Entries\Collection;
use Manuskript\Entries\Concerns\Context;
use Manuskript\Entries\Entry;
use Manuskript\Fields\Field;
use Manuskript\Resources\Resource;

class EloquentEntryFactory
{
    public function make(Resource $resource, ?Model $model = null, ?Context $context = null): Entry
    {
        $key = null;
        $fields = $resource->fields();

        if (! is_null($context)) {
            $fields = array_filter(
                $fields,
                fn ($field) => $field->visibility()?->value === $context->value,
            );
        }

        if (! is_null($model)) {
            $key = $model->getKey();

            foreach ($fields as $field) {
                $this->fillField($field, $model);
            }
        }

        return new Entry($key, $fields);
    }

    public function collect(Resource $resource, array $models, ?Context $context = null): Collection
    {
        return new Collection(array_map(
            fn (Model $model) => $this->make($resource, $model, $context),
            $models
        ));
    }

    private function fillField(Field $field, Model $data): void
    {
        $key = $field->name();

        $field->fill($data->$key);
    }
}

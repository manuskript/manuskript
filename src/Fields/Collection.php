<?php

namespace Manuskript\Fields;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Manuskript\Support\Collection as BaseCollection;

class Collection extends BaseCollection
{
    public function hydrate(array|Model $values): self
    {
        return $this->each->hydrate($values);
    }

    public function toModelAttributes(): array
    {
        $attributes = [];

        foreach($this->items as $field) {
            if(! $field instanceof Field) {
                throw new InvalidArgumentException(sprintf(
                    '$field must be of type %s, %s given',
                    Field::class,
                    gettype($field)
                ));
            }

            $attributes[$field->getName()] = $field->toModelAttribute();
        }

        return $attributes;
    }
}

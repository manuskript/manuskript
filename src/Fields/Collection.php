<?php

namespace Manuskript\Fields;

use Closure;
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
        return $this->mapToNames(
            static fn ($field) => $field->toModelAttribute()
        );
    }

    public function rules(): array
    {
        return $this->mapToNames(
            static fn ($field) => $field->getRules()
        );
    }


    private function mapToNames(Closure $callback): array
    {
        $items = [];

        foreach($this->items as $field) {
            if(! $field instanceof Field) {
                throw new InvalidArgumentException(sprintf(
                    '$field must be of type %s, %s given',
                    Field::class,
                    gettype($field)
                ));
            }

            $items[$field->getName()] = $callback($field);
        }

        return $items;
    }
}

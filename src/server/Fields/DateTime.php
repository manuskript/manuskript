<?php

namespace Manuskript\Fields;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Manuskript\Contracts\Sortable as SortableField;

class DateTime extends Field implements SortableField
{
    use Sortable;

    protected string $type = 'datetime';

    protected function fill(array|Model $values): void
    {
        $value = is_array($values)
            ? $values[$this->name]
            : $values->getAttribute($this->name);

        $date = $this->getDate($value);

        $this->setValue($date);
    }

    protected function getDate($value)
    {
        if (!$value) {
            return;
        }

        if (!$value instanceof Carbon) {
            $value = Carbon::parse($value);
        }

        return $value->format('Y-m-d\Th:i:s');
    }
}

<?php

namespace Manuskript\Fields;

use Manuskript\Contracts\Sortable as SortableField;

class Number extends Field implements SortableField
{
    use Sortable;

    protected string $type = 'number';

    public function max($value)
    {
        return $this->decorate('max', $value);
    }

    public function min($value)
    {
        return $this->decorate('min', $value);
    }

    public function step($value)
    {
        return $this->decorate('step', $value);
    }
}

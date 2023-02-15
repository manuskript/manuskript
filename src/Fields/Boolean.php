<?php

namespace Manuskript\Fields;

use Manuskript\Contracts\Sortable as SortableField;

class Boolean extends Field implements SortableField
{
    use Sortable;

    protected string $type = 'boolean';

    protected mixed $default = false;

    public function label($value)
    {
        return $this->decorate('label', $value);
    }
}

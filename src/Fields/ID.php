<?php

namespace Manuskript\Fields;

use Manuskript\Contracts\Sortable as SortableField;

class ID extends Field implements SortableField
{
    use Sortable;

    protected string $type = 'id';

    public static function make($label = 'ID', $name = null): static
    {
        return parent::make($label, $name);
    }
}

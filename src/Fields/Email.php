<?php

namespace Manuskript\Fields;

use Manuskript\Contracts\Sortable as SortableField;

class Email extends Field implements SortableField
{
    use Sortable;

    protected string $type = 'email';

    public static function make($label = 'Email', $name = null): static
    {
        return parent::make($label, $name);
    }
}

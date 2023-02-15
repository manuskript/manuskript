<?php

namespace Manuskript\Fields;

use Manuskript\Contracts\Sortable as SortableField;

class DateTime extends Field implements SortableField
{
    use Sortable;

    protected string $type = 'datetime';
}

<?php

namespace Manuskript\Fields;

use Manuskript\Contracts\Sortable as SortableField;

class Text extends Field implements SortableField
{
    use Sortable;

    protected string $type = 'text';
}

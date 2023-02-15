<?php

namespace Manuskript\Fields;

use Manuskript\Contracts\Sortable as SortableField;

class ID extends Field implements SortableField
{
    use Sortable;

    protected string $type = 'id';

    protected bool $readOnly = true;

    public static function make($label = 'ID', $name = null): static
    {
        return parent::make($label, $name);
    }

    protected function booted(): void
    {
        $this->showOnCreate(false);
        $this->showOnIndex(true);
        $this->sortable();
    }
}

<?php

namespace Manuskript\Fields;

use Manuskript\Fields\Concerns\Sortable;

class Id extends Field
{
    use Sortable;

    protected array $attributes = [
        'readOnly' => true,
    ];

    public static function make($label = 'ID', $name = null): static
    {
        return parent::make($label, $name);
    }

    protected function booting()
    {
        $this->showOnIndex(true);
    }
}

<?php

namespace Manuskript\Fields;

use Illuminate\Support\Arr;

trait Sortable
{
    public function sortable(bool $boolean = true): self
    {
        return $this->decorate('sortable', $boolean);
    }

    public function isSortable(): bool
    {
        return Arr::get($this->decorators, 'sortable', false);
    }
}

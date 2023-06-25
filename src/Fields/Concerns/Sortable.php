<?php

namespace Manuskript\Fields\Concerns;

trait Sortable
{
    protected bool $sortable = false;

    public function sortable(bool|callable $boolean = true): static
    {
        $this->sortable = $boolean;

        return $this;
    }
}

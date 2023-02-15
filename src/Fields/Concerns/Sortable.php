<?php

namespace Manuskript\Fields\Concerns;

trait Sortable
{
    protected bool $sortable = false;

    public function sortable(bool|callable $boolean = true): self
    {
        $this->sortable = $boolean;

        return $this;
    }
}

<?php

namespace Manuskript\Contracts;

interface Sortable
{
    public function sortable(bool $boolean = true);

    public function isSortable(): bool;
}

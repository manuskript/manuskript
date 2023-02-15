<?php

namespace Manuskript\Actions;

use Manuskript\Support\Collection as BaseCollection;

class Collection extends BaseCollection
{
    public function byName($name): Action
    {
        return $this->first(fn ($action) => $action->name() === $name);
    }
}

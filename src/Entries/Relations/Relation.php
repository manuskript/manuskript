<?php

namespace Manuskript\Entries\Relations;

use Illuminate\Database\Eloquent\Relations\Relation as Eloquent;

abstract class Relation
{
    public function __construct(
        protected Eloquent $relation
    ) {
    }

    abstract public function save(array $value);
}

<?php

namespace Manuskript\Entries\Relations;

use Manuskript\Support\Arr;

class BelongsTo extends Relation
{
    public function save(?array $value)
    {
        $this->relation->associate(
            Arr::get($value ?? [], 'key')
        );
    }
}

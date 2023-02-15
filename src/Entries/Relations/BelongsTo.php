<?php

namespace Manuskript\Entries\Relations;

class BelongsTo extends Relation
{
    public function save(array $value)
    {
        $this->relation->associate($value['key']);
    }
}

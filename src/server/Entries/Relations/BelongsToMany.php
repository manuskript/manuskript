<?php

namespace Manuskript\Entries\Relations;

use Manuskript\Support\Arr;

class BelongsToMany extends Relation
{
    public function save($value)
    {
        $related = $this->getRelated(is_array($value) ? $value : []);

        $this->relation->sync($related);
    }

    protected function getRelated($value)
    {
        $keys = Arr::isList($value)
            ? array_map(fn ($v) => $v['key'], $value)
            : [Arr::get($value, 'key')];

        return $this->relation->getRelated()->find($keys);
    }
}

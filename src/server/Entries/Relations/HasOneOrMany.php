<?php

namespace Manuskript\Entries\Relations;

use Manuskript\Support\Arr;

class HasOneOrMany extends Relation
{
    public function save(?array $value)
    {
        $related = $this->getRelated($value ?? []);

        $this->relation->saveMany($related);
    }

    protected function getRelated($value)
    {
        $keys = Arr::isList($value)
            ? array_map(fn ($v) => $v['key'], $value)
            : [Arr::get($value, 'key')];

        return $this->relation->getRelated()->find($keys);
    }
}

<?php

namespace Manuskript\Entries\Relations;

use Illuminate\Database\Eloquent\Relations as Eloquent;

class Factory
{
    public static function make($model, $method)
    {
        return static::getInstance(
            $model->$method()
        );
    }

    protected static function getInstance(Eloquent\Relation $relation)
    {
        if ($relation instanceof Eloquent\HasOneOrMany) {
            return new HasOneOrMany($relation);
        }

        if ($relation instanceof Eloquent\BelongsToMany) {
            return new BelongsToMany($relation);
        }

        if ($relation instanceof Eloquent\BelongsTo) {
            return new BelongsTo($relation);
        }
    }
}

<?php

namespace Manuskript\Fields\Concerns;

use Closure;

trait ModifiesValueBeforeSave
{
    protected static ?Closure $saveUsing;

    public static function saveUsing(Closure $callback)
    {
        static::$saveUsing = $callback;
    }

    public function toModelAttribute(): mixed
    {
        if(isset(static::$saveUsing)) {
            $modifier = static::$saveUsing;

            return $modifier($this->getRawValue());
        }

        return parent::toModelAttribute();
    }

    abstract public function getRawValue(): mixed;
}

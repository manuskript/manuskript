<?php

namespace Manuskript\Concerns;

use Closure;

trait Searchable
{
    protected static ?Closure $search;

    public static function searchUsing(Closure $callback): void
    {
        static::$search = $callback;
    }

    public static function search()
    {
        return static::$search;
    }

    public static function searchable(): bool
    {
        return isset(static::$search);
    }
}

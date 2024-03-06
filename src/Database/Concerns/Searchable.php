<?php

namespace Manuskript\Database\Concerns;

use Closure;

trait Searchable
{
    protected static ?Closure $search = null;

    public static function searchUsing(Closure $callback): void
    {
        static::$search = $callback;
    }

    public static function search($query, $term): void
    {
        (static::$search ?: fn() => null)($query, $term);
    }

    public static function searchable(): bool
    {
        return isset(static::$search);
    }
}

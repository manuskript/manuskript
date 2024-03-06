<?php

namespace Manuskript\Database\Concerns;

use Closure;
use Manuskript\Database\Query\Order;

trait Orderable
{
    protected static ?Closure $order = null;

    public static function orderUsing(Closure $callback): void
    {
        static::$order = $callback;
    }

    public static function order($query, $column, $direction = 'asc'): void
    {
        (static::$order ?: new Order())($query, $column, $direction);
    }
}

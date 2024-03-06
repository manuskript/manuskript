<?php

namespace Manuskript\Database\Query;

class Order
{
    public function __invoke($query, $column, $direction): void
    {
        $query->orderBy($column, $direction);
    }
}

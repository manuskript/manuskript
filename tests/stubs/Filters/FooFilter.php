<?php

namespace Manuskript\Tests\stubs\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Manuskript\Filters\Filter;

class FooFilter extends Filter
{
    protected function handle(Builder $query, Request $request): void
    {
        //
    }
}

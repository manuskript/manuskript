<?php

namespace Manuskript\Pagination;

use Illuminate\Http\Request;
use Manuskript\Support\Collection as BaseCollection;

class Collection extends BaseCollection
{
    public function getCurrent(Request $request): int
    {
        return $request->perPage ?? $this->first();
    }
}

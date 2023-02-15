<?php

namespace Manuskript\Pagination;

use Illuminate\Http\Request;
use Manuskript\Support\Collection as BaseCollection;

class Collection extends BaseCollection
{
    public function getCurrent(Request $request)
    {
        return $request->perPage ?? $this->first();
    }
}

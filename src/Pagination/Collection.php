<?php

namespace Manuskript\Pagination;

use Illuminate\Http\Request;
use Manuskript\Support\Collection as BaseCollection;

/**
 * @template TKey of array-key
 * @template TValue
 * @extends BaseCollection<TKey,TValue>
 */
class Collection extends BaseCollection
{
    public function getCurrent(Request $request): int
    {
        return $request->perPage ?? $this->first();
    }
}

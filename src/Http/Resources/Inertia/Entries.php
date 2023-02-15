<?php

namespace Manuskript\Http\Resources\Inertia;

use Manuskript\Entries\Entry;
use Manuskript\Http\Resources\HasView;
use Manuskript\Http\Resources\InertiaResourceCollection;

class Entries extends InertiaResourceCollection
{
    use HasView;

    public static $wrap = 'rows';

    public function toArray($request)
    {
        return $this->collection->map(function ($model) use ($request) {
            return new Entry($request->resource, $model);
        });
    }
}

<?php

namespace Manuskript\Http\Resources\Json;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Manuskript\Entries\Entry;
use Manuskript\Http\Resources\HandlesFields;

class Entries extends ResourceCollection
{
    use HandlesFields;

    public static $wrap = 'rows';

    public function toArray($request)
    {
        return $this->collection->map(function ($model) use ($request) {
            return new Entry($request->resource, $model, $this->fields);
        });
    }
}

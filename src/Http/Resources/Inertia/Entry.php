<?php

namespace Manuskript\Http\Resources\Inertia;

use Manuskript\Entries\Entry as EntriesEntry;
use Manuskript\Http\Resources\HasView;
use Manuskript\Http\Resources\InertiaResource;

class Entry extends InertiaResource
{
    use HasView;

    public function toArray($request)
    {
        return new EntriesEntry($request->resource, $this->resource);
    }
}

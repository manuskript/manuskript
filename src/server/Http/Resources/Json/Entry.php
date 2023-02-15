<?php

namespace Manuskript\Http\Resources\Json;

use Illuminate\Http\Resources\Json\JsonResource;
use Manuskript\Entries\Entry as EntriesEntry;
use Manuskript\Http\Resources\HandlesFields;

class Entry extends JsonResource
{
    use HandlesFields;

    public function toArray($request)
    {
        return new EntriesEntry($request->resource, $this->resource, $this->fields);
    }
}

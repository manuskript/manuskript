<?php

namespace Manuskript\Http\Resources\Inertia;

use Manuskript\Http\Resources\HasView;
use Manuskript\Http\Resources\InertiaResource;

class Files extends InertiaResource
{
    use HasView;

    public function toArray($request)
    {
        return [
            'directories' => $this->resource->get('dir') ?? [],
            'files' => $this->resource->get('file') ?? [],
        ];
    }
}

<?php

namespace Manuskript\Http\Response;

use Illuminate\Http\Resources\Json\ResourceResponse;
use Inertia\Inertia;

class InertiaResponse extends ResourceResponse
{
    public function toResponse($request)
    {
        return Inertia::render($this->resource->view, $this->wrap(
            $this->resource->resolve($request),
            $this->resource->with($request),
            $this->resource->additional
        ))->toResponse($request);
    }
}

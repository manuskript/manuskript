<?php

namespace Manuskript\Http\Response;

use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Inertia\Inertia;

class PaginatedInertiaResponse extends PaginatedResourceResponse
{
    public function toResponse($request)
    {
        return Inertia::render($this->resource->view, $this->wrap(
            $this->resource->resolve($request),
            array_merge_recursive(
                $this->paginationInformation($request),
                $this->resource->with($request),
                $this->resource->additional
            )
        ))->toResponse($request);
    }
}

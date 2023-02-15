<?php

namespace Manuskript\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;
use Manuskript\Http\Response\InertiaResponse;
use Manuskript\Http\Response\PaginatedInertiaResponse;

class InertiaResourceCollection extends ResourceCollection
{
    public function toResponse($request)
    {
        if ($this->resource instanceof AbstractPaginator || $this->resource instanceof AbstractCursorPaginator) {
            $this->resource->appends($request->query());

            return (new PaginatedInertiaResponse($this))->toResponse($request);
        }

        return (new InertiaResponse($this))->toResponse($request);
    }
}

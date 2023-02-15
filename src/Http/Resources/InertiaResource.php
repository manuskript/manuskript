<?php

namespace Manuskript\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Manuskript\Http\Response\InertiaResponse;

class InertiaResource extends JsonResource
{
    public function toResponse($request)
    {
        return (new InertiaResponse($this))->toResponse($request);
    }
}

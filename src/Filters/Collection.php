<?php

namespace Manuskript\Filters;

use Illuminate\Http\Request;
use Manuskript\Support\Collection as BaseCollection;

class Collection extends BaseCollection
{
    public function active(Request $request): self
    {
        return $this->filter->isActive($request);
    }
}

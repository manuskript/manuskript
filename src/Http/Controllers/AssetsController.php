<?php

namespace Manuskript\Http\Controllers;

use Illuminate\Http\Request;
use Manuskript\Filesystem\Builder;
use Manuskript\Http\Response;

class AssetsController
{
    public function index(Builder $builder, ?string $folder = null)
    {
        return Response::make(
            'Assets/Index',
            $builder->getDirectory($folder)->toArray()
        );
    }
}

<?php

namespace Manuskript\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Manuskript\Filesystem\Builder;
use Manuskript\Http\RedirectResponse;
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

    public function store(Builder $builder, Request $request, ?string $folder = null)
    {
        $files = $request->file('files');

        $paths = $builder->store($folder, $files);

        $count = count($paths);

        return RedirectResponse::back()->withMessage($count === 1 ? 'File uploaded.' : $count . ' files uploaded.');
    }
}

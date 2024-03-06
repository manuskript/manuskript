<?php

namespace Manuskript\Actions;

use Illuminate\Http\Request;
use Manuskript\Database\Resource;

class Destroy extends Action
{
    protected static ?string $label = 'Delete';

    protected static ?string $name = 'destroy';

    protected static string $level = 'danger';

    protected function handle(Resource $resource, Request $request): void
    {
        $resource->model()->delete();
    }
}

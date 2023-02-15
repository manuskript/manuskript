<?php

namespace Manuskript\Http\Controllers;

use Manuskript\Http\Request;

class ActionsController extends Controller
{
    public function __invoke($resource, $action, Request $request)
    {
        $action = $resource::actions()
            ->first(fn ($item) => $item->name() === $action);

        $action($request);
    }
}

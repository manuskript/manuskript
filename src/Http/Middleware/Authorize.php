<?php

namespace Manuskript\Http\Middleware;

use Inertia\Inertia;
use Manuskript\Manuskript;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Authorize
{
    public function handle($request, $next)
    {
        if (!Manuskript::check($request)) {
            throw new AccessDeniedHttpException();
        }

        if ($resource = $request->resource) {
            Inertia::share([
                'can' => function () use ($resource) {
                    return [
                        'viewAny' => Manuskript::can('viewAny', $resource),
                        'view' => Manuskript::can('view', $resource),
                        'create' => Manuskript::can('create', $resource),
                        'update' => Manuskript::can('update', $resource),
                        'delete' => Manuskript::can('delete', $resource),
                        'restore' => Manuskript::can('restore', $resource),
                    ];
                },
            ]);
        }

        return $next($request);
    }
}

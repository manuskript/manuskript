<?php

namespace Manuskript\Http\Controllers;

use Manuskript\Columns\Repository as Columns;
use Manuskript\Entries\Repository as Entries;
use Manuskript\Http\Request;
use Manuskript\Http\Resources\Inertia;

class TrashedEntriesController
{
    public function index($resource, Columns $columns, Entries $entries, Request $request)
    {
        $query = $entries->trash()->only(
            $columns = $columns->fromVisibillity('index', $resource, $request)
        )->query($resource);

        if ($order = $columns->filter->order()->first()) {
            $query->orderBy($order->getName(), $order->order());
        }

        $perPage = $resource::perPage();

        $collection = $query->paginate($request->perPage ?? $perPage->first());

        return (new Inertia\Entries($collection))
            ->view('Trash')
            ->additional(
                compact('columns', 'perPage')
            );
    }

    public function show($resource, $model, Entries $entries)
    {
        $entry = $entries->trash()->find($model, $resource);

        return (new Inertia\Entry($entry))
            ->view('Show');
    }

    public function restore($resource, Entries $entries, Request $request)
    {
        $entries->trash()->restore($request->models, $resource);

        return back();
    }

    public function destroy($resource, Entries $entries, Request $request)
    {
        $entries->trash()->forceDelete($request->models, $resource);

        return back();
    }
}

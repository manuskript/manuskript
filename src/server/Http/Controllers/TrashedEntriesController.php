<?php

namespace Manuskript\Http\Controllers;

use Manuskript\Columns\Repository as Columns;
use Manuskript\Entries\Repository as Entries;
use Manuskript\Http\Request;
use Manuskript\Http\Resources\Inertia;

class TrashedEntriesController extends Controller
{
    public function index($resource, Columns $columns, Entries $entries, Request $request)
    {
        $this->authorize('viewAny', $resource);

        $searchable = $resource::searchable();

        $query = $entries->trash()->only(
            $columns = $columns->fromVisibillity('index', $resource, $request)
        )->query($resource);

        if ($searchable && $request->has('q')) {
            $resource::search($query, $request->q);
        }

        if ($order = $columns->filter->order()->first()) {
            $query->orderBy($order->getName(), $order->order());
        }

        $perPage = $resource::perPage();

        $collection = $query->paginate($request->perPage ?? $perPage->first());

        return (new Inertia\Entries($collection))
            ->view('Trash')
            ->additional(array_merge(
                compact('columns', 'perPage', 'searchable'),
                ['label' => $resource::label()],
            ));
    }

    public function show($resource, $model, Entries $entries)
    {
        $this->authorize('view', $resource);

        $entry = $entries->trash()->find($model, $resource);

        return (new Inertia\Entry($entry))
            ->additional([
                'label' => $resource::label(),
                'resource' => $resource::slug(),
                'model' => $model,
                'trashed' => true,
            ])
            ->view('Show');
    }

    public function restore($resource, Entries $entries, Request $request)
    {
        $this->authorize('restore', $resource);

        $entries->trash()->restore($request->models, $resource);

        return back();
    }

    public function destroy($resource, Entries $entries, Request $request)
    {
        $this->authorize('delete', $resource);

        $entries->trash()->forceDelete($request->models, $resource);

        return redirect()->route('manuskript.entries.index', $resource::slug());
    }
}

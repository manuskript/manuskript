<?php

namespace Manuskript\Http\Controllers;

use Manuskript\Columns\Repository as Columns;
use Manuskript\Entries\Repository as Entries;
use Manuskript\Http\Request;
use Manuskript\Http\Resources\Inertia;
use Manuskript\Support\Str;

class EntriesController extends Controller
{
    public function index($resource, Columns $columns, Entries $entries, Request $request)
    {
        $this->authorize('viewAny', $resource);

        $searchable = $resource::searchable();

        $actions = $resource::actions();

        $filters = $resource::filters($request);

        $query = $entries->only(
            $columns = $columns->fromVisibillity('index', $resource, $request)
        )->query($resource);

        if ($searchable && $request->filled('q')) {
            $resource::search($query, $request->q);
        }

        $filters->filter->isActive()
            ->each(fn ($filter) => $filter($query));

        if ($order = $columns->filter->order()->first()) {
            $query->orderBy($order->getName(), $order->order());
        }

        $perPage = $resource::perPage();

        $collection = $query->paginate($request->perPage ?? $perPage->first());

        return (new Inertia\Entries($collection))
            ->view('Index')
            ->fields($columns->map->getName())
            ->additional(array_merge(compact('actions', 'columns', 'filters', 'perPage', 'searchable'), [
                'softDeletes' => $resource::handlesSoftDeletes(),
                'urls' => [
                    'current' => route('manuskript.entries.index', $resource::slug()),
                    'create' => route('manuskript.entries.create', $resource::slug()),
                ],
                'label' => $resource::label(),
                'resource' => $resource::slug(),
            ]));
    }

    public function show($resource, $model, Entries $entries, Columns $columns)
    {
        $this->authorize('view', $resource);

        $entry = $entries->only(
            $columns = $columns->fromVisibillity('edit', $resource)
        )->find($model, $resource);

        return (new Inertia\Entry($entry))
            ->additional([
                'label' => $resource::label(),
                'resource' => $resource::slug(),
                'model' => $model,
            ])
            ->fields($columns->map->getName())
            ->view('Show');
    }

    public function create($resource, Columns $columns)
    {
        $this->authorize('create', $resource);

        return \Inertia\Inertia::render('Create', [
            'fields' => $columns->fromVisibillity('create', $resource)->map->field(),
            'label' => $resource::label(),
            'resource' => $resource::slug(),
        ]);
    }

    public function edit($resource, $model, Entries $entries, Columns $columns)
    {
        $this->authorize('update', $resource);

        $entry = $entries->only(
            $columns = $columns->fromVisibillity('edit', $resource)
        )->find($model, $resource);

        return (new Inertia\Entry($entry))
            ->additional([
                'label' => $resource::label(),
                'resource' => $resource::slug(),
                'model' => $model,
            ])
            ->fields($columns->map->getName())
            ->view('Edit');
    }

    public function store($resource, Entries $entries, Request $request)
    {
        $this->authorize('create', $resource);

        $request->validate($resource::rules());

        $entries->create($resource, $request->all());

        return redirect()->route('manuskript.entries.index', $resource::slug())->with('toast', [
            'message' => 'Entry created!',
            'status' => 'success',
            'key' => Str::random(32),
        ]);
    }

    public function update($resource, $model, Entries $entries, Request $request)
    {
        $this->authorize('update', $resource);

        $request->validate($resource::rules());

        $entries->update($model, $resource, $request->all());

        return redirect()->route('manuskript.entries.index', $resource::slug())->with('toast', [
            'message' => 'Entry updated!',
            'status' => 'success',
            'key' => Str::random(32),
        ]);
    }

    public function destroy($resource, $model, Entries $entries)
    {
        $this->authorize('delete', $resource);

        $entries->withTrashed()->delete([$model], $resource);

        return redirect()->route('manuskript.entries.index', $resource::slug());
    }
}

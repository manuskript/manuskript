<?php

namespace Manuskript\Http\Controllers;

use Illuminate\Support\Str;
use Manuskript\Http\Request;
use Manuskript\Http\Resources\Inertia;
use Manuskript\Columns\Repository as Columns;
use Manuskript\Entries\Repository as Entries;

class EntriesController
{
    public function index($resource, Columns $columns, Entries $entries, Request $request)
    {
        $actions = $resource::actions();

        $filters = $resource::filters($request);

        $query = $entries->only(
            $columns = $columns->fromVisibillity('index', $resource, $request)
        )->query($resource);

        $filters->filter->isActive()
            ->each(fn ($filter) => $filter($query));

        if ($order = $columns->filter->order()->first()) {
            $query->orderBy($order->getName(), $order->order());
        }

        $perPage = $resource::perPage();

        $softDeletes = $resource::handlesSoftDeletes();

        $collection = $query->paginate($request->perPage ?? $perPage->first());

        return (new Inertia\Entries($collection))
            ->view('Index')
            ->additional(array_merge(compact('actions', 'columns', 'filters', 'perPage', 'softDeletes'), [
                'urls' => [
                    'current' => route('manuskript.entries.index', $resource::slug()),
                    'create' => route('manuskript.entries.create', $resource::slug()),
                ],
                'label' => $resource::label(),
            ]));
    }

    public function create($resource)
    {
        return \Inertia\Inertia::render('Create', [
            'fields' => $resource::fields(),
        ]);
    }

    public function edit($resource, $model, Entries $entries, Columns $columns)
    {
        $entry = $entries->only(
            $columns->fromVisibillity('edit', $resource)
        )->find($model, $resource);

        return (new Inertia\Entry($entry))
            ->view('Edit');
    }

    public function store($resource, Entries $entries, Request $request)
    {
        $entries->create($resource, $request->all());

        return redirect()->route('manuskript.entries.index', $resource::slug())->with('toast', [
            'message' => 'Entry created!',
            'status' => 'success',
            'key' => Str::random(32)
        ]);
    }

    public function update($resource, $model, Entries $entries, Request $request)
    {
        $entries->update($model, $resource, $request->all());

        return redirect()->route('manuskript.entries.index', $resource::slug())->with('toast', [
            'message' => 'Entry updated!',
            'status' => 'success',
            'key' => Str::random(32)
        ]);
    }

    public function destroy($resource, Entries $entries, Request $request)
    {
        $entries->trash()->delete($request->models, $resource);

        return back();
    }
}

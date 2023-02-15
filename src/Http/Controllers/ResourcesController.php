<?php

namespace Manuskript\Http\Controllers;

use Illuminate\Http\Request;
use Manuskript\Database\Resource;
use Manuskript\Http\RedirectResponse;
use Manuskript\Http\Response;

class ResourcesController
{
    public function index($resource, Request $request)
    {
        $perPage = $resource::perPage();
        $filters = $resource::filters();
        $searchable = $resource::searchable();
        $columns = $resource::columns();

        $query = $resource::query()->context('index');

        $filters->active($request)->each(
            fn ($filter) => $query->run($filter)
        );

        if ($request->has('q')) {
            $query->run($resource::searchUsing(), $request->get('q'));
        }

        if ($request->has('sortBy')) {
            $query->run($resource::orderUsing(), $request->get('sortBy'), $request->get('dir', 'asc'));
        }

        $items = $query->simplePaginate($perPage->getCurrent($request))
            ->appends($request->query());

        return Response::make('Resources/Index', $items->toArray())
            ->with('columns', $columns)
            ->with('filters', $filters)
            ->with('pagination', $perPage)
            ->with('searchable', $searchable);
    }

    public function show($resource, $model)
    {
        $item = $resource::query()->context('show')->findOrFail($model);

        return Response::make('Resources/Show')
            ->with('data', $item);
    }

    public function create($resource)
    {
        $item = new Resource(new $resource::$model(), 'create');

        return Response::make('Resources/Create')
            ->with('data', $item);
    }

    public function store($resource, Request $request)
    {
        //
    }

    public function edit($resource, $model)
    {
        $item = $resource::query()->context('edit')->findOrFail($model);

        return Response::make('Resources/Edit')
            ->with('data', $item)
            ->with('updateUrl', $item->getUrl('resources.update'));
    }

    public function update($resource, $model, Request $request)
    {
        $fields = $resource::fieldsByContext('edit');

        $attributes = $fields->hydrate(
            $request->all()
        )->toModelAttributes();

        $resource::query()->update($model, $attributes);

        return RedirectResponse::back();
    }
}

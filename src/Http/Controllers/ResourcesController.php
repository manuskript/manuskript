<?php

namespace Manuskript\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Manuskript\Database\Resource;
use Manuskript\Http\Controllers\Concerns\AuthorizeRequest;
use Manuskript\Http\RedirectResponse;
use Manuskript\Http\Response;

class ResourcesController
{
    use AuthorizeRequest;

    public function index($resource, Request $request)
    {
        $this->authorize('viewAny', $resource::policy());

        $perPage = $resource::perPage();
        $filters = $resource::filters();
        $searchable = $resource::searchable();
        $columns = $resource::columns();

        $query = $resource::query()->context('index');

        $filters->active($request)->each(
            fn($filter) => $query->run($filter)
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
        $this->authorize('view', $resource::policy());

        $item = $resource::query()->context('show')->findOrFail($model);

        return Response::make('Resources/Show')
            ->with('data', $item);
    }

    public function create($resource)
    {
        $this->authorize('create', $resource::policy());

        $item = new Resource(new $resource::$model(), 'create');

        return Response::make('Resources/Create')
            ->with('data', $item);
    }

    public function store($resource, Request $request)
    {
        $this->authorize('create', $resource::policy());
        //
    }

    public function edit($resource, $model)
    {
        $this->authorize('update', $resource::policy());

        $item = $resource::query()->context('edit')->findOrFail($model);

        return Response::make('Resources/Edit')
            ->with('data', $item)
            ->with('updateUrl', $item->getUrl('resources.update'));
    }

    public function update($resource, $model, Request $request)
    {
        $this->authorize('update', $resource::policy());

        $fields = $resource::fieldsByContext('edit');

        $validator = Validator::make($request->all(), $fields->rules());

        if ($validator->fails()) {
            return RedirectResponse::back()->withErrors($validator);
        }
        $attributes = $fields->hydrate(
            $validator->validated()
        )->toModelAttributes();

        $resource::query()->update($model, $attributes);

        return RedirectResponse::route('resources.show', [$resource::slug(), $model])
            ->withMessage("{$resource::label()} updated.");
    }
}

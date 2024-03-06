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

    /**
     * @param class-string<\Manuskript\Resource> $resource
     */
    public function index(string $resource, Request $request): Response
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
            $resource::search($query, $request->get('q'));
        }

        if ($request->has('sortBy')) {
            $resource::order($query, $request->get('sortBy'), $request->get('dir', 'asc'));
        }

        $items = $query->simplePaginate($perPage->getCurrent($request))
            ->appends($request->query());

        return Response::make('Resources/Index', $items->toArray())
            ->with('columns', $columns)
            ->with('filters', $filters)
            ->with('pagination', $perPage)
            ->with('searchable', $searchable);
    }

    /**
     * @param class-string<\Manuskript\Resource> $resource
     */
    public function show(string $resource, $model): Response
    {
        $this->authorize('view', $resource::policy());

        /** @var Resource $item */
        $item = $resource::query()->context('show')->findOrFail($model);

        return Response::make('Resources/Show')
            ->with('data', $item);
    }

    /**
     * @param class-string<\Manuskript\Resource> $resource
     */
    public function create(string $resource): Response
    {
        $this->authorize('create', $resource::policy());

        $item = new Resource(new $resource::$model(), 'create');

        return Response::make('Resources/Create')
            ->with('data', $item);
    }

    /**
     * @param class-string<\Manuskript\Resource> $resource
     */
    public function store(string $resource, Request $request): RedirectResponse
    {
        $this->authorize('create', $resource::policy());

        $model = null;

        return RedirectResponse::route('resources.show', [$resource::slug(), $model])
            ->withMessage("{$resource::label()} created.");
    }

    /**
     * @param class-string<\Manuskript\Resource> $resource
     */
    public function edit(string $resource, $model): Response
    {
        $this->authorize('update', $resource::policy());

        /** @var Resource $item */
        $item = $resource::query()->context('edit')->findOrFail($model);

        return Response::make('Resources/Edit')
            ->with('data', $item)
            ->with('updateUrl', $item->url('resources.update'));
    }

    /**
     * @param class-string<\Manuskript\Resource> $resource
     */
    public function update(string $resource, $model, Request $request): RedirectResponse
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

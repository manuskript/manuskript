<?php

namespace Manuskript\Database;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Builder
{
    protected string $context = '';

    public function __construct(
        protected EloquentBuilder $query
    ) {
    }

    public function context($context)
    {
        $this->context = $context;

        return $this;
    }

    public function batch(array $jobs)
    {
        foreach ($jobs as $job) {
            [$callback, $params] = $job;

            $params = is_array($params) ? array_values($params) : [];

            $this->run($callback, ...$params);
        }

        return $this;
    }

    public function run(callable $callback, ...$params)
    {
        if (is_callable($callback)) {
            $callback($this->query, ...$params);
        }

        return $this;
    }

    public function update($id, array $values)
    {
        return $this->query->whereKey($id)->update($values);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $paginator = $this->query->paginate($perPage, $columns, $pageName, $page);

        return $this->transformPaginatorItems($paginator);
    }

    public function simplePaginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $paginator = $this->query->simplePaginate($perPage, $columns, $pageName, $page);

        return $this->transformPaginatorItems($paginator);
    }

    public function cursorPaginate($perPage = null, $columns = ['*'], $cursorName = 'cursor', $cursor = null)
    {
        $paginator = $this->query->simplePaginate($perPage, $columns, $cursorName, $cursor);

        return $this->transformPaginatorItems($paginator);
    }

    public function __call($method, $args)
    {
        $result = call_user_func([$this->query, $method], ...$args);

        if ($result instanceof EloquentBuilder) {
            return $this;
        }

        if ($result instanceof EloquentCollection) {
            return $this->transformModels($result->all());
        }

        if ($result instanceof EloquentModel) {
            return $this->toResource($result);
        }

        return $result;
    }

    protected function toResource(EloquentModel $model): Resource
    {
        return new Resource($model, $this->context);
    }

    protected function transformModels(array $models): Collection
    {
        return new Collection(array_map(
            fn ($model) => $this->toResource($model),
            $models
        ));
    }

    protected function transformPaginatorItems($paginator)
    {
        $paginator->setCollection(
            $this->transformModels($paginator->items())
        );

        return $paginator;
    }
}

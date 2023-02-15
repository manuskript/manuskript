<?php

namespace Manuskript\Entries;

use LogicException;
use Manuskript\Manuskript;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Manuskript\Entries\Relations\BelongsTo as BelongsToRelation;
use Manuskript\Entries\Relations\Factory as RelationFactory;

class Repository
{
    protected  bool $onlyTrashed = false;

    protected ?Collection $fields = null;

    public function trash($boolean = true): self
    {
        $this->onlyTrashed = $boolean;

        return $this;
    }

    public function only($fields): self
    {
        $this->fields = $fields instanceof Collection
            ? $fields
            : Collection::make([$fields]);

        return $this;
    }

    public function find($key, $resource): Model
    {
        return $this->query($resource)->findOrFail($key);
    }

    public function relation($key, $parent)
    {
        $resource = $this->getResourceFromRelation(
            $this->getEloquentRelation(new $parent::$model, $key)
        );

        return $this->query($resource);
    }

    public function restore($keys, $resource)
    {
        $key = $resource::keyName();

        return $this->query($resource)->whereIn($key, $keys)->restore();
    }

    public function delete($keys, $resource)
    {
        return $resource::$model::destroy($keys);
    }

    public function forceDelete($keys, $resource)
    {
        $key = $resource::keyName();

        return $this->query($resource)->whereIn($key, $keys)->forceDelete();
    }

    public function create($resource, $payload)
    {
        return $this->saveModel(
            new $resource::$model,
            $resource,
            $payload
        );
    }

    public function update($key, $resource, $payload)
    {
        return $this->saveModel($this->find($key, $resource), $resource, $payload);
    }

    private function saveModel($model, $resource, $payload)
    {
        $model->fill(Arr::only($payload, $resource::getFillableFields()));

        $relations = Collection::make(
            Arr::only($payload, $resource::getRelationFields())
        )->map(function ($value, $method) use ($model) {
            $relation = RelationFactory::make($model, $method);

            return $relation instanceof BelongsToRelation
                ? tap(function () {
                }, fn () => $relation->save($value))
                : fn () => $relation->save($value);
        });

        $model->save();

        $relations->each(fn ($callable) => $callable());
    }

    public function query($resource)
    {
        $query = $resource::$model::query();

        if ($this->onlyTrashed) {
            $query->onlyTrashed();
        }

        if ($this->fields) {
            $query->select($this->getColumns($query));
            $query->with($this->getRelations($query));
        }

        return $query;
    }

    protected function getColumns(Builder $query)
    {
        $model = $query->getModel();

        $columns = $this->fields->map(function ($field) use ($model) {
            $column = $field->getName();

            if (!$field->isRelation()) {
                return $column;
            }

            $relation = $this->getEloquentRelation($model, $column);

            if ($relation instanceof BelongsTo) {
                return $relation->getForeignKeyName();
            }
        })->filter()->values()->toArray();

        if (in_array(SoftDeletes::class, class_uses_recursive($model::class))) {
            $columns[] = 'deleted_at';
        }

        return [$model->getKeyName(), ...$columns];
    }

    protected function getRelations(Builder $query)
    {
        $relations = $this->fields->filter->isRelation()->keyBy->getName();

        return $relations->map(function ($field, $method) use ($query) {

            $select = $this->getSelectsFromRelation(
                $this->getEloquentRelation($query->getModel(), $method)
            );

            return fn ($subquery) => $subquery->select([...$select, $field->getTitle()]);
        })->toArray();
    }

    protected function getKeyNameFromRelation(Relation $relation)
    {
        $model = $relation->getModel();

        return implode('.', [
            $model->getTable(),
            $model->getKeyName(),
        ]);
    }

    protected function getSelectsFromRelation(Relation $relation)
    {
        $selects = [$this->getKeyNameFromRelation($relation)];

        if ($relation instanceof HasOneOrMany) {
            $selects[] = $relation->getForeignKeyName();
        }

        return $selects;
    }

    protected function getResourceFromRelation(Relation $relation)
    {
        return Manuskript::fromModel(
            get_class($relation->getRelated())
        );
    }

    protected function getEloquentRelation($model, $method)
    {
        if (!$model->isRelation($method)) {
            throw new LogicException(sprintf(
                '%s::%s must return a relationship instance.',
                $model::class,
                $method
            ));
        }

        return $model->$method();
    }
}

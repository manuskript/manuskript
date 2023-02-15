<?php

namespace Manuskript\Http\Controllers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Manuskript\Manuskript;
use Manuskript\Http\Request;
use Manuskript\Columns\Repository as Columns;
use Manuskript\Entries\Entry;
use Manuskript\Entries\Repository as Entries;
use Manuskript\Http\Resources\Json;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RelationsController
{
    public function index(string $resource, string $method, Entries $entries, Columns $columns, Request $request)
    {
        $title = $resource::field($method)->getTitle();

        $resource = $this->getRelatedResource(
            $this->getRelation($resource, $method)
        );

        $query = $entries->only(
            $column = $columns->fromName($title, $resource, $request)
        )->query($resource);

        if ($column->order()) {
            $query->orderBy($column->getName(), $column->order());
        }

        $columns = [$column];

        $entries = $query->paginate(15);

        request()->merge(['resource' => $resource]);

        return (new Json\Entries($entries))
            ->fields([$title])
            ->additional(compact('columns'));
    }

    public function create(string $resource, $model, string $method, Entries $entries, Columns $columns)
    {
        $relation = $this->getRelation($resource, $method);

        $model = $entries->find($model, $resource);

        $fields = $this->getRelatedResource($relation)::fields();

        foreach ($fields as $field) {
            if ($field->isRelation()) {
                $field->setValue($field->makeEntry($resource, $model));
            }
        }

        return $fields;
    }

    protected function getRelation($resource, $method)
    {
        $parent = new $resource::$model;

        if (!$parent->isRelation($method)) {
            throw new NotFoundHttpException();
        }

        return $parent->$method();
    }

    protected function getRelatedResource(Relation $relation)
    {
        return Manuskript::fromModel(
            get_class($relation->getRelated())
        );
    }
}

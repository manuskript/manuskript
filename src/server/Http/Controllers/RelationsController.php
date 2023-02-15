<?php

namespace Manuskript\Http\Controllers;

use Manuskript\Columns\Repository as Columns;
use Manuskript\Entries\Repository as Entries;
use Manuskript\Http\Request;
use Manuskript\Http\Resources\Json;
use Manuskript\Manuskript;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RelationsController extends Controller
{
    public function index(string $resource, string $method, Entries $entries, Columns $columns, Request $request)
    {
        $title = $resource::field($method)->getTitle();

        $resource = Manuskript::fromModel(
            $this->getRelation($resource, $method)->getRelated()
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

    public function show(string $resource, string $method, $id, Entries $entries, Columns $columns, Request $request)
    {
        $title = $resource::field($method)->getTitle();

        $resource = Manuskript::fromModel(
            $this->getRelation($resource, $method)->getRelated()
        );

        $query = $entries->only(
            $columns->fromName($title, $resource, $request)
        )->query($resource);

        $entry = $query->find($id);

        request()->merge(['resource' => $resource]);

        return (new Json\Entry($entry))
            ->fields([$title]);
    }

    public function create(string $resource, string $method)
    {
        $relation = $this->getRelation($resource, $method);

        $fields = $this->getCreateFields($resource, $relation->getRelated());

        $resource = Manuskript::fromModel(
            $relation->getRelated()
        );

        return [
            'fields' => $fields,
            'resource' => $resource::slug(),
        ];
    }

    public function store(string $resource, string $method, Entries $entries, Request $request)
    {
        $title = $resource::field($method)->getTitle();

        $resource = Manuskript::fromModel(
            $this->getRelation($resource, $method)->getRelated()
        );

        $request->validate($resource::rules());

        $entry = $entries->create($resource, $request->all());

        request()->merge(['resource' => $resource]);

        return (new Json\Entry($entry))
            ->fields([$title]);
    }

    public function getCreateFields($resource, $model)
    {
        $fields = array_filter(Manuskript::fromModel($model)::fields(), function ($field) use ($resource, $model) {
            if ($field->isRelation()) {
                $method = $field->getName();

                return !$model->$method()->getRelated() instanceof $resource::$model;
            }

            return true;
        });

        return array_values($fields);
    }

    protected function getRelation($resource, $method)
    {
        $parent = new $resource::$model();

        if (!$parent->isRelation($method)) {
            throw new NotFoundHttpException();
        }

        return $parent->$method();
    }
}

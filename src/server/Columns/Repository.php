<?php

namespace Manuskript\Columns;

use Closure;
use Manuskript\Fields\Field;
use Manuskript\Http\Request;
use Manuskript\Support\Collection;

class Repository
{
    public function keys($resource, $visibillity): array
    {
        return $this->fields($resource, $visibillity)
            ->map->getName()->toArray();
    }

    public function fromName($name, $resource, Request $request = null): Collection|Column
    {
        if (is_array($name)) {
            return Collection::make($name)->map(fn ($name) => $this->transform($resource::field($name), $request));
        }

        return $this->transform($resource::field($name), $request);
    }

    public function fromVisibillity($visibillity, $resource, Request $request = null): Collection
    {
        return $this->fields($resource, $visibillity)->map(
            fn ($field) => $this->transform($field, $request)
        );
    }

    protected function transform(Field $field, Request $request = null): Column
    {
        return tap(new Column($field), $this->order($request));
    }

    protected function order(Request $request = null): Closure
    {
        return function ($column) use ($request) {
            if ($request && $column->getName() === $request->sortBy) {
                $column->setOrder($request->get('dir', 'asc'));
            } else {
                $column->setOrder(null);
            }
        };
    }

    protected function fields($resource, $visibillity): Collection
    {
        return Collection::make($resource::fields())
            ->filter->isVisible($visibillity)
            ->values();
    }
}

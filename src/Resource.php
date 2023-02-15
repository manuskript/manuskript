<?php

namespace Manuskript;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Manuskript\Actions\Destroy;
use Manuskript\Http\Request;
use ReflectionClass;

class Resource
{
    protected static ?string $label;

    protected static ?string $model;

    protected static ?string $group;

    protected static ?string $slug;

    protected static ?array $filters;

    protected static ?array $actions;

    protected static array $perPage = [
        15, 25, 50,
    ];

    public static function fields(): array
    {
        return [];
    }

    public static function field($name)
    {
        return Arr::first(
            static::fields(),
            fn ($field) => $field->hasName($name)
        );
    }

    public static function handlesSoftDeletes()
    {
        return in_array(SoftDeletes::class, class_uses_recursive(static::$model));
    }

    public static function perPage(): Collection
    {
        return Collection::make(static::$perPage);
    }

    public static function label()
    {
        return Str::of(static::$label ?? (new ReflectionClass(static::$model))->getShortName());
    }

    public static function slug()
    {
        return static::$slug ?? static::label()->slug();
    }

    public static function group()
    {
        return static::$group ?? 'Resources';
    }

    public static function filters(Request $request)
    {
        $filters = static::$filters ?? [];

        return Collection::make($filters)
            ->map(fn ($filter) => tap(
                $filter::make(static::class),
                fn ($f) => $f->setActive(in_array($filter::name(), $request->filters()))
            ));
    }

    public static function actions()
    {
        $actions = static::$actions ?? [
            Destroy::class,
        ];

        return Collection::make($actions)
            ->map(fn ($action) => $action::make(static::class));
    }

    public static function keyName()
    {
        return (new static::$model)->getKeyname();
    }

    public static function getFillableFields()
    {
        $fields = Collection::make(static::fields());

        return $fields->filter->isNotRelation()->map->getName()->toArray();
    }

    public static function getRelationFields()
    {
        $fields = Collection::make(static::fields());

        return $fields->filter->isRelation()->map->getName()->toArray();
    }
}

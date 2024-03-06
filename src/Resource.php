<?php

namespace Manuskript;

use Manuskript\Actions\Collection as ActionsCollection;
use Manuskript\Actions\Destroy;
use Manuskript\Concerns\RegistersMenu;
use Manuskript\Database\Concerns\Orderable;
use Manuskript\Database\Concerns\Searchable;
use Manuskript\Database\Query\Builder;
use Manuskript\Facades\URL;
use Manuskript\Fields\Collection as FieldsCollection;
use Manuskript\Filters\Collection as FiltersCollection;
use Manuskript\Pagination\Collection as PaginationCollection;
use Manuskript\Policies\Policy;
use Manuskript\Support\Collection;
use Manuskript\Support\Str;
use ReflectionClass;

class Resource
{
    use RegistersMenu;
    use Orderable;
    use Searchable;

    public static string $model;

    protected static ?string $policy;

    protected static ?array $actions;

    protected static ?array $filters;

    protected static ?string $label;

    protected static ?string $slug;

    protected static ?string $group;

    protected static array $perPage = [
        15, 25, 50,
    ];

    public static function actions(): ActionsCollection
    {
        return new ActionsCollection(array_map(
            fn($action) => new $action(),
            static::$actions ?? [Destroy::class]
        ));
    }

    public static function filters(): FiltersCollection
    {
        return new FiltersCollection(array_map(
            fn($filter) => new $filter(),
            static::$filters ?? []
        ));
    }

    public static function columns(): Collection
    {
        return Collection::make(static::fields())
            ->filter->shouldRender('index')
            ->map->toColumn();
    }

    public static function fields(): array
    {
        return [];
    }

    public static function label(): string
    {
        return static::$label ?? (new ReflectionClass(static::$model))->getShortName();
    }

    public static function menuLabel(): string
    {
        return static::label();
    }

    public static function rootUrl(): string
    {
        return URL::route('resources.index', static::slug());
    }

    public static function slug(): string
    {
        return static::$slug ?? Str::slug(static::label());
    }

    public static function perPage(): PaginationCollection
    {
        return PaginationCollection::make(static::$perPage);
    }

    public static function fieldsByContext($context): FieldsCollection
    {
        return new FieldsCollection(array_filter(
            static::fields(),
            fn($field) => $field->shouldRender($context)
        ));
    }

    public static function policy(): Policy
    {
        if (isset(static::$policy)) {
            return new static::$policy();
        }

        return new Policy();
    }

    public static function query(): Builder
    {
        return new Builder(static::$model::query());
    }
}

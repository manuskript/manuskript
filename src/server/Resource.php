<?php

namespace Manuskript;

use Illuminate\Database\Eloquent\SoftDeletes;
use Manuskript\Actions\Destroy;
use Manuskript\Fields\Field;
use Manuskript\Http\Request;
use Manuskript\Policies\HandlesPolicies;
use Manuskript\Support\Arr;
use Manuskript\Support\Collection;
use Manuskript\Support\Str;
use ReflectionClass;

class Resource
{
    use HandlesPolicies;

    protected static ?string $label;

    protected static ?string $model;

    protected static ?string $group;

    protected static ?string $slug;

    protected static ?array $filters;

    protected static ?array $actions;

    protected static array $perPage = [
        15, 25, 50,
    ];

    protected static ?bool $showInMenu;

    protected static ?bool $searchable;

    protected static ?array $cascadeOnDelete;

    public static function search($query, $term): void
    {
        //
    }

    public static function fields(): array
    {
        return [];
    }

    public static function field($name): Field
    {
        return Arr::first(
            static::fields(),
            fn ($field) => $field->hasName($name)
        );
    }

    public static function handlesSoftDeletes(): bool
    {
        return in_array(SoftDeletes::class, class_uses_recursive(static::$model));
    }

    public static function perPage(): Collection
    {
        return Collection::make(static::$perPage);
    }

    public static function label(): string
    {
        return static::$label ?? (new ReflectionClass(static::$model))->getShortName();
    }

    public static function slug(): string
    {
        return static::$slug ?? Str::slug(static::label());
    }

    public static function group(): string
    {
        return static::$group ?? 'Resources';
    }

    public static function showInMenu(): bool
    {
        return static::$showInMenu ?? true;
    }

    public static function searchable(): bool
    {
        return static::$searchable ?? false;
    }

    public static function filters(Request $request): Collection
    {
        $filters = static::$filters ?? [];

        return Collection::make($filters)
            ->map(fn ($filter) => tap(
                $filter::make(static::class),
                fn ($f) => $f->setActive(in_array($filter::name(), $request->filters()))
            ));
    }

    public static function actions(): Collection
    {
        $default = Manuskript::can('delete', static::class) ? [Destroy::class] : [];

        $actions = static::$actions ?? $default;

        return Collection::make($actions)
            ->map(fn ($action) => $action::make(static::class));
    }

    public static function keyName(): string
    {
        return (new static::$model())->getKeyname();
    }

    public static function rules(): array
    {
        $fields = Collection::make(static::fields());

        return $fields->keyBy(fn ($field) => $field->getName())->map->getRules()->toArray();
    }

    public static function getFillableFields(): array
    {
        $fields = Collection::make(static::fields());

        return $fields->filter->isNotRelation()->map->getName()->toArray();
    }

    public static function getRelationFields(): array
    {
        $fields = Collection::make(static::fields());

        return $fields->filter->isRelation()->map->getName()->toArray();
    }
}

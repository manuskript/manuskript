<?php

namespace Manuskript\Menu;

use InvalidArgumentException;
use Manuskript\Manuskript;
use Manuskript\Support\Arr;
use Manuskript\Support\Collection;

class Factory
{
    protected static $menus = [];

    public static function register(Menu $menu): void
    {
        static::$menus[] = $menu;
    }

    public static function clear(): void
    {
        static::$menus = [];
    }

    public static function registered(): array
    {
        return static::$menus;
    }

    public function make(string $label, array $items = []): Menu
    {
        $items = array_map(function ($item) {
            if ($item instanceof Item) {
                return $item;
            }

            if (is_array($item)) {
                return $this->makeItem($item);
            }

            throw new InvalidArgumentException(sprintf(
                '$items[] must be of type array, %s given',
                gettype($item)
            ));
        }, $items);

        return tap(
            new Menu($label, $items),
            static fn ($menu) => static::register($menu)
        );
    }

    public function makeItem(array|string $label, $url = null): Item
    {
        if (is_array($label)) {
            if (Arr::isList($label)) {
                return new Item(...$label);
            }

            extract($label);
        }

        return new Item($label, $url);
    }

    public function fromResources(?array $resources = null): Collection
    {
        return Collection::make($resources ?? Manuskript::$resources)
            ->filter(fn ($resource) => $resource::isVisibleInMenu())
            ->groupBy(fn ($resource) => $resource::menuGroup())
            ->map(function ($resources, $label) {
                return $this->make($label, $resources->map(function ($resource) {
                    return [$resource::menuLabel(), fn () => $resource::rootUrl()];
                })->toArray());
            })->values();
    }
}

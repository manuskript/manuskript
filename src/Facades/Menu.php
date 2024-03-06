<?php

namespace Manuskript\Facades;

use Illuminate\Support\Facades\Facade;
use Manuskript\Menu\Factory;

/**
 * @method static void register(\Manuskript\Menu\Menu $menu)
 * @method static void clear()
 * @method static array registered()
 * @method static \Manuskript\Menu\Menu make(string $label, array $items = [])
 * @method static \Manuskript\Menu\Item makeItem(array|string $label, $url = null)
 * @method static \Manuskript\Support\Collection fromResources(?array $resources = null)
 */
class Menu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}

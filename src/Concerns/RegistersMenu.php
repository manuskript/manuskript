<?php

namespace Manuskript\Concerns;

trait RegistersMenu
{
    protected static ?bool $showInMenu;

    protected static ?string $menuGroup;

    abstract public static function menuLabel(): string;

    abstract public static function rootUrl(): string;

    public static function showInMenu(bool $boolean = true): void
    {
        static::$showInMenu = $boolean;
    }

    public static function hideInMenu(bool $boolean = true): void
    {
        static::showInMenu(!$boolean);
    }

    public static function isHiddenInMenu(): bool
    {
        return !static::isVisibleInMenu();
    }

    public static function isVisibleInMenu(): bool
    {
        return static::$showInMenu ?? true;
    }

    public static function menuGroup(): string
    {
        return static::$menuGroup ?? 'Menu';
    }
}

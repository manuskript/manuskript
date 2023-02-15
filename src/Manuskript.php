<?php

namespace Manuskript;

use Composer\InstalledVersions;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Manuskript\Auth\Authorize;
use Manuskript\Support\Arr;
use Manuskript\Support\Str;

class Manuskript
{
    public static $resources;

    public static $authorize;

    public static function version()
    {
        return InstalledVersions::getVersion('manuskript/manuskript');
    }

    public static function can($scope, $resource)
    {
        $method = Str::camel('can_' . $scope);

        return call_user_func([$resource, $method], Container::getInstance()->make(Request::class));
    }

    public static function auth(callable $callback)
    {
        static::$authorize = $callback;
    }

    public static function check($request)
    {
        return (static::$authorize ?: new Authorize())($request);
    }

    public static function register(array|string|callable $resources): void
    {
        if (is_callable($resources)) {
            $resources = $resources(Container::getInstance()->make(Request::class));
        }

        static::$resources = array_merge(static::resources(), is_array($resources) ? $resources : [$resources]);
    }

    public static function resolve(callable $callback): ?string
    {
        return Arr::first(static::resources(), $callback);
    }

    public static function resources(): array
    {
        return static::$resources ?? [];
    }
}

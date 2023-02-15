<?php

namespace Manuskript;

use Composer\InstalledVersions;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Manuskript\Auth\Authorize;
use Manuskript\Exceptions\UnresolvableResourceException;
use Manuskript\Http\Request;
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

    public static function resources()
    {
        return static::$resources ?? [];
    }

    public static function register(array $resources)
    {
        static::$resources = array_merge(static::resources(), $resources);
    }

    public static function fromModel(string|Model $model)
    {
        $model = is_string($model) ? $model : $model::class;

        return Arr::first(
            static::resources(),
            fn ($resource) => $resource::$model === $model,
            fn () => throw new UnresolvableResourceException(sprintf('Resource for the given model %s does not exist.', $model))
        );
    }

    public static function resolve($alias)
    {
        return Arr::first(
            static::resources(),
            fn ($resource) => (string) $resource::slug() === $alias,
            fn () => throw new UnresolvableResourceException(sprintf('Resource for the given alias %s does not exist.', $alias))
        );
    }
}

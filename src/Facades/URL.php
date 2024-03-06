<?php

namespace Manuskript\Facades;

use Illuminate\Support\Facades\Facade;
use Manuskript\Routing\UrlGenerator;

/**
 * @method static string previous(mixed $fallback = false)
 * @method static string route(string $name, ?array $parameters = [], ?bool $absolute = false)
 * @method static string to(string $path, mixed $extra = [], ?bool $absolute = null)
 */
class URL extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UrlGenerator::class;
    }
}

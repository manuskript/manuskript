<?php

namespace Manuskript\Routing;

use Illuminate\Routing\UrlGenerator as Illuminate;

class UrlGenerator
{
    public function __construct(
        protected Illuminate $generator
    ) {
    }

    public function route($name, $parameters = [], $absolute = false): string
    {
        return $this->generator->route('manuskript.' . $name, $parameters, $absolute);
    }

    public function __call($method, $args): mixed
    {
        return call_user_func([$this->generator, $method], ...$args);
    }
}

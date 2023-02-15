<?php

namespace Manuskript\Routing;

use Illuminate\Routing\UrlGenerator as Illuminate;

class UrlGenerator
{
    public function __construct(
        protected Illuminate $generator
    ) {
    }

    public function route($name, $parameters = [], $absolute = true)
    {
        return $this->generator->route('manuskript.'.$name, $parameters, $absolute);
    }

    public function __call($method, $args)
    {
        return call_user_func([$this->generator, $method], $args);
    }
}

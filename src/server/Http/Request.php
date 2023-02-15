<?php

namespace Manuskript\Http;

use Illuminate\Container\Container;
use Illuminate\Http\Request as HttpRequest;
use InvalidArgumentException;

class Request extends HttpRequest
{
    public function filters()
    {
        return $this->filter ?? [];
    }

    public function payload()
    {
        if (! $this->resource) {
            throw new InvalidArgumentException();
        }

        $fields = collect($this->resource::fields())->filter->isNotRelation();

        dd($fields);
    }

    public function route($param = null, $default = null)
    {
        return Container::getInstance()
            ->make('request')
            ->route($param, $default);
    }
}

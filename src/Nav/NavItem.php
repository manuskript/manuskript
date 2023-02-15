<?php

namespace Manuskript\Nav;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class NavItem implements Arrayable
{
    public function __construct(
        protected string $resource
    ) {
    }

    public function group()
    {
        return $this->resource::group();
    }

    public function label()
    {
        return Str::plural($this->resource::label());
    }

    public function url()
    {
        return URL::route('manuskript.entries.index', [
            'resource' => $this->resource::slug(),
        ]);
    }

    public function toArray()
    {
        return [
            'label' => $this->label(),
            'url' => $this->url(),
        ];
    }
}

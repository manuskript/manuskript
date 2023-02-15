<?php

namespace Manuskript\Nav;

use Manuskript\Contracts\Arrayable;
use Manuskript\Facades\URL;

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
        return $this->resource::label();
    }

    public function url()
    {
        return URL::route('entries.index', [
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

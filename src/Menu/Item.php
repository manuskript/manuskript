<?php

namespace Manuskript\Menu;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use JsonSerializable;
use Manuskript\Contracts\Arrayable;
use Manuskript\Facades\URL;
use Manuskript\Support\Str;

class Item implements Arrayable, JsonSerializable
{
    public function __construct(
        protected string $label,
        protected string|Closure $url
    ) {
    }

    public function url()
    {
        $url = $this->url;

        return URL::to(is_callable($url) ? $url() : $url);
    }

    public function isActive(?Request $request = null): bool
    {
        $request = $request ?? Container::getInstance()->make(Request::class);

        return Str::startsWith($request->url(), $this->url());
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'url' => $this->url(),
            'active' => $this->isActive(),
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}

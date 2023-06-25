<?php

namespace Manuskript\Fields\Concerns;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Manuskript\Support\Arr;

trait ConditionalRendered
{
    protected $shouldRender = [
        'index' => false,
        'show' => false,
        'create' => false,
        'edit' => false,
    ];

    public function shouldRender($key): bool
    {
        return Arr::get($this->shouldRender, $key, false);
    }

    public function showOnIndex(bool|callable $boolean = true): static
    {
        return $this->updateShouldRender('index', $boolean);
    }

    public function showOnShow(bool|callable $boolean = true): static
    {
        return $this->updateShouldRender('show', $boolean);
    }

    public function showOnCreate(bool|callable $boolean = true): static
    {
        return $this->updateShouldRender('create', $boolean);
    }

    public function showOnEdit(bool|callable $boolean = true): static
    {
        return $this->updateShouldRender('edit', $boolean);
    }

    protected function updateShouldRender(string $key, bool|callable $value = true): static
    {
        if (is_array($key)) {
            $this->shouldRender = array_merge($this->shouldRender, $key);
        } else {
            $this->shouldRender[$key] = is_callable($value)
                ? $value(Container::getInstance()->make(Request::class))
                : $value;
        }

        return $this;
    }
}

<?php

namespace Manuskript\Fields;

use Illuminate\Container\Container;
use Manuskript\Http\Request;

abstract class Fieldset
{
    protected array $merged = [];

    public static function make(): static
    {
        return new static();
    }

    public function __invoke(): array
    {
        $request = Container::getInstance()->make(Request::class);

        return array_merge($this->fields($request), $this->merged);
    }

    public function merge($fields): self
    {
        $toMerge = is_callable($fields)
            ? $fields(Container::getInstance()->make(Request::class))
            : $fields;

        $this->merged = array_merge(
            $this->merged,
            is_array($toMerge) ? $toMerge : [$toMerge]
        );

        return $this;
    }

    abstract protected function fields(Request $request): array;
}

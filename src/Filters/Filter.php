<?php

namespace Manuskript\Filters;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use JsonSerializable;
use Manuskript\Contracts\Arrayable;
use ReflectionClass;

abstract class Filter implements Arrayable, JsonSerializable
{
    protected static ?string $name = null;

    protected static ?string $label = null;

    public static function label(): string
    {
        return static::$label ?? (new ReflectionClass(static::class))->getShortName();
    }

    public static function name(): string
    {
        return static::$name ?? md5(static::class);
    }

    public function __invoke(Builder $query): void
    {
        $this->handle($query, Container::getInstance()->make(Request::class));
    }

    abstract protected function handle(Builder $query, Request $request): void;

    public function isActive(Request $request = null)
    {
        $request = $request ?? Container::getInstance()->make(Request::class);

        return in_array(static::name(), $request->filter ?? []);
    }

    public function toArray()
    {
        return [
            'name' => $this->name(),
            'label' => $this->label(),
            'active' => $this->isActive(),
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}

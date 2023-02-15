<?php

namespace Manuskript;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use JsonSerializable;
use Manuskript\Contracts\Arrayable;
use Manuskript\Http\Request;
use ReflectionClass;

abstract class Filter implements Arrayable, JsonSerializable
{
    protected static ?string $name = null;

    protected static ?string $label = null;

    protected bool $active = false;

    public function __construct(
        protected string $resource
    ) {
    }

    public static function make(string $resource)
    {
        return new static($resource);
    }

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

    public function isActive()
    {
        return $this->active;
    }

    public function setActive($boolean = true)
    {
        $this->active = $boolean;
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

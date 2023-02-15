<?php

namespace Manuskript;

use JsonSerializable;
use Manuskript\Contracts\Arrayable;
use Manuskript\Http\Request;
use ReflectionClass;

abstract class Action implements Arrayable, JsonSerializable
{
    protected static ?string $name = null;

    protected static ?string $label = null;

    protected static string $level = 'prompt';

    public function __construct(
        protected string $resource,
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

    public function __invoke(Request $request): void
    {
        $this->handle($request);
    }

    abstract protected function handle(Request $request): void;

    public function toArray()
    {
        return [
            'name' => $this->name(),
            'label' => $this->label(),
            'level' => static::$level,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}

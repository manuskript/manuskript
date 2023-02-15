<?php

namespace Manuskript\Actions;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use JsonSerializable;
use Manuskript\Contracts\Arrayable;
use Manuskript\Database\Collection;
use Manuskript\Database\Resource;
use ReflectionClass;

abstract class Action implements Arrayable, JsonSerializable
{
    protected static ?string $name = null;

    protected static ?string $label = null;

    protected static string $level = 'prompt';

    public static function label(): string
    {
        return static::$label ?? (new ReflectionClass(static::class))->getShortName();
    }

    public static function name(): string
    {
        return static::$name ?? md5(static::class);
    }

    public function __invoke(Collection|Resource $resources, $request = null): void
    {
        $request = $request ?? Container::getInstance()->make(Request::class);

        if ($resources instanceof Resource) {
            $this->handle($resources, $request);
        }

        if ($resources instanceof Collection) {
            $resources->each(fn ($resource) => $this->handle($resource, $request));
        }
    }

    abstract protected function handle(Resource $resource, Request $request): void;

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

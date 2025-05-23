<?php

namespace Manuskript\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Manuskript\Fields\Field;

abstract class Resource
{
    /**
     * @var class-string<Model>
     */
    public string $model;

    /**
     * @return Field[]
     */
    public function fields(): array
    {
        return [];
    }

    public function label(): string
    {
        return (string) $this->getStringable()->headline()->singular();
    }

    public function pluralLabel(): string
    {
        return (string) $this->getStringable()->headline()->plural();
    }

    public function getKey(): string
    {
        return (string) $this->getStringable()->headline()->plural()->slug();
    }

    private function getStringable(): Stringable
    {
        $shortModelName = (new \ReflectionClass($this->model))->getShortName();

        return new Stringable($shortModelName);
    }
}

<?php

namespace Manuskript\Fields;

use LogicException;
use Manuskript\Manuskript;
use Illuminate\Support\Str;
use Manuskript\Entries\Entry;
use Illuminate\Database\Eloquent;

class Relation extends Field
{
    protected string $type = 'relation';

    protected ?string $title = null;

    protected array $architecture = [];

    public static function make($label, $name = null): static
    {
        return new static($label, $name ?? Str::camel($label));
    }

    public function isRelation(): bool
    {
        return true;
    }

    public function makeEntry($resource, $model)
    {
        return new Entry($resource, $model, [$this->title]);
    }

    protected function fill(array|Eloquent\Model $parent): void
    {
        $method = $this->name;

        if (is_array($parent)) {
            throw new LogicException('Relations can not hydrated from an array');
        }

        $model = $parent->$method()->getRelated();

        $resource = Manuskript::fromModel($model::class);

        $models = $parent->$method;

        if ($models instanceof Eloquent\Model) {
            $this->setValue($this->makeEntry($resource, $models));
        }

        if ($models instanceof Eloquent\Collection) {
            $this->setValue(
                $models->map(fn ($model) => $this->makeEntry($resource, $model))
            );
        }
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function title($title): self
    {
        $this->title = $title;

        return $this;
    }
}

<?php

namespace Manuskript\Fields;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use JsonSerializable;
use Manuskript\Contracts\Arrayable;
use Manuskript\Fields\Concerns\ConditionalRendered;
use Manuskript\Fields\Concerns\ValidationRules;
use Manuskript\Fields\Constraints\Column;
use Manuskript\Fields\Constraints\FieldValue;
use Manuskript\Support\Arr;
use Manuskript\Support\Str;
use ReflectionClass;

abstract class Field implements Arrayable, JsonSerializable
{
    use ConditionalRendered;
    use ValidationRules;

    protected mixed $default = null;

    protected mixed $value;

    protected string $type = 'text';

    protected array $attributes = [];

    protected bool $hydrated = false;

    protected bool $booted = false;

    public function __construct(
        protected string $label,
        protected string $name
    ) {
        $this->boot();
    }

    public static function make($label, $name = null): static
    {
        return new static($label, $name ?? Str::slug($label, '_'));
    }

    public function hydrate(array|Model $values): void
    {
        $value = is_array($values)
            ? $values[$this->name]
            : $values->getAttribute($this->name);

        $value = new FieldValue($value);

        $this->hydrating($value);

        $this->fill($value);

        $this->hydrated = true;

        $this->hydrated($value);
    }

    public function default($value): static
    {
        $this->default = $value;

        return $this;
    }

    public function readOnly(bool|callable $boolean = true): static
    {
        return $this->setAttribute('readOnly', $boolean);
    }

    protected function fill(FieldValue $value): void
    {
        $this->setValue($value->getValue());
    }

    public function getAttribute($key, $default = null): mixed
    {
        return Arr::get($this->attributes, $key, $default);
    }

    public function setAttribute($key, $value): static
    {

        $value = is_callable($value)
            ? $value(Container::getInstance()->make(Request::class))
            : $value;

        $this->attributes = Arr::set($this->attributes, $key, $value);

        return $this;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

    public function getValue(): mixed
    {
        if ($this->hydrated) {
            return $this->value;
        }

        return $this->value ?? $this->default;
    }

    public function getRawValue(): mixed
    {
        return $this->value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    protected function boot(): void
    {
        $this->booting();

        $this->bootTraits();
        $this->booted = true;

        $this->booted();
    }

    protected function bootTraits($class = null): void
    {
        $class = $class ?? new ReflectionClass($this);

        foreach ($class->getTraits() as $trait) {
            $method = 'boot' . $trait->getShortName();

            if ($trait->hasMethod($method)) {
                $this->$method();
            }
        }

        if ($parent = $class->getParentClass()) {
            $this->bootTraits($parent);
        }
    }

    protected function booting(): void
    {
        //
    }

    protected function booted(): void
    {
        //
    }

    protected function hydrating($value): void
    {
        //
    }

    protected function hydrated($value): void
    {
        //
    }

    public function toColumn(): Column
    {
        return new Column($this);
    }

    public function toModelAttribute(): mixed
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return array_merge($this->attributes, [
            'label' => $this->label,
            'name' => $this->name,
            'type' => $this->type,
            'value' => $this->getValue(),
        ]);
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}

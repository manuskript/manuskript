<?php

namespace Manuskript\Fields;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use JsonSerializable;
use Manuskript\Contracts\Arrayable;
use Manuskript\Http\Request;
use Manuskript\Support\Str;

abstract class Field implements Arrayable, JsonSerializable
{
    protected mixed $value = null;

    protected mixed $default = '';

    protected string $type;

    protected bool $readOnly = false;

    protected ?array $decorators = null;

    protected array $visible = [
        'index' => false,
        'edit' => true,
        'create' => true,
    ];

    protected bool $required = false;

    protected array $rules = [];

    protected array $public = [
        'name', 'label', 'type', 'value', 'default', 'decorators', 'visible', 'readOnly', 'required',
    ];

    public function __construct(
        protected string $label,
        protected string $name
    ) {
        $this->initialize();
    }

    public static function make($label, $name = null): static
    {
        return new static($label, $name ?? Str::slug($label, '_'));
    }

    public function hydrate(array|Model $values): void
    {
        $this->hydrating($values);

        $this->fill($values);

        $this->hydrated($values);
    }

    protected function fill(array|Model $values): void
    {
        $value = is_array($values)
            ? $values[$this->name]
            : $values->getAttribute($this->name);

        $this->setValue($value);
    }

    public function default($value): self
    {
        $this->default = $value;

        return $this;
    }

    public function readOnly(bool|callable $boolean = true): self
    {
        $value = is_callable($boolean)
            ? $boolean(Container::getInstance()->make(Request::class))
            : $boolean;

        $this->readOnly = $value;

        return $this;
    }

    public function showOnIndex(bool|callable $boolean = true): self
    {
        return $this->updateVisibillity('index', $boolean);
    }

    public function showOnEdit(bool|callable $boolean = true): self
    {
        return $this->updateVisibillity('edit', $boolean);
    }

    public function showOnCreate(bool|callable $boolean = true): self
    {
        return $this->updateVisibillity('create', $boolean);
    }

    public function isVisible($key)
    {
        return $this->visible[$key];
    }

    public function isRelation(): bool
    {
        return false;
    }

    public function isNotRelation(): bool
    {
        return !$this->isRelation();
    }

    public function hasName($name): bool
    {
        return $this->name === $name;
    }

    public function required(bool|callable $boolean = true)
    {
        $required =  is_callable($boolean)
            ? $boolean(Container::getInstance()->make(Request::class))
            : $boolean;

        if ($required && !in_array('required', $this->rules)) {
            $this->rules[] = 'required';
        }

        $this->required = $required;

        return $this;
    }

    public function rules(array|callable $rules, bool $override = false): self
    {
        $values = is_callable($rules)
            ? $rules(Container::getInstance()->make(Request::class))
            : $rules;

        if (!is_array($values)) {
            throw new InvalidArgumentException(sprintf(
                'Argument #1 ($rules) must be of type array, %s given.',
                gettype($values)
            ));
        }

        $this->required(in_array('required', $values));

        $this->rules = $override ? $values : array_unique(array_merge($this->rules, $values));

        return $this;
    }

    public function getRules()
    {
        return $this->rules;
    }

    protected function decorate($key, $value): self
    {
        $value = is_callable($value)
            ? $value(Container::getInstance()->make(Request::class))
            : $value;

        if (is_array($this->decorators)) {
            $this->decorators[$key] = $value;
        } else {
            $this->decorators = [$key => $value];
        }

        return $this;
    }

    protected function updateVisibillity(string $key, bool|callable $value): self
    {
        $this->visible[$key] = is_callable($value)
            ? $value(Container::getInstance()->make(Request::class))
            : $value;

        return $this;
    }

    protected function hydrating(array|Model $values): void
    {
        //
    }

    protected function hydrated(array|Model $values): void
    {
        //
    }

    protected function booting(): void
    {
        //
    }

    protected function booted(): void
    {
        //
    }

    protected function filled(): void
    {
        //
    }

    private function initialize(): void
    {
        $this->booting();

        //

        $this->booted();
    }

    public function setValue(mixed $value)
    {
        $this->value = $value ?? $this->default;

        $this->filled();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getType()
    {
        return $this->type;
    }

    public function toArray()
    {
        $props = array_reduce($this->public, function ($array, $prop) {
            $array[$prop] = $this->{$prop};

            return $array;
        }, []);

        return array_filter($props);
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}

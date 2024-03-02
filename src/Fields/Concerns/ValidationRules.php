<?php

namespace Manuskript\Fields\Concerns;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Validation\Rule;

trait ValidationRules
{
    protected array $rules = [];

    public function required(bool|callable $boolean = true): static
    {
        $required =  is_callable($boolean)
            ? $boolean(Container::getInstance()->make(Request::class))
            : $boolean;

        if ($required && !in_array('required', $this->rules)) {
            $this->rules[] = 'required';
        }

        return $this->setAttribute('required', $required);
    }

    public function addRules(Rule|string|array $rules): self
    {
        $this->rules = array_unique(array_merge(
            $this->rules,
            is_array($rules) ? $rules : [$rules]
        ));

        return $this;
    }

    public function rules(array|callable $rules, bool $override = false): static
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

    public function getRules(): array
    {
        return $this->rules;
    }
}

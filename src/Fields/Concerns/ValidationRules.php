<?php

namespace Manuskript\Fields\Concerns;

use Illuminate\Container\Container;
use InvalidArgumentException;

trait ValidationRules
{
    protected array $rules = [];

    public function required(bool|callable $boolean = true): self
    {
        $required =  is_callable($boolean)
            ? $boolean(Container::getInstance()->make(Request::class))
            : $boolean;

        if ($required && !in_array('required', $this->rules)) {
            $this->rules[] = 'required';
        }

        return $this->setAttribute('required', $required);
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
}

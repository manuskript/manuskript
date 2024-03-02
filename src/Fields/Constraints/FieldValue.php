<?php

namespace Manuskript\Fields\Constraints;

class FieldValue
{
    public function __construct(
        protected mixed $value
    ) {}

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }
}

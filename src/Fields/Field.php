<?php

namespace Manuskript\Fields;

use Manuskript\Fields\Concerns\Visibility;

abstract class Field
{
    private ?Visibility $visibility = null;

    public function __construct(
        private readonly string $name,
        private readonly mixed $value,
    ) {
    }

    abstract public function fill(mixed $value): void;

    abstract public function type(): string;

    public function name(): string
    {
        return $this->name;
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function visibility(): ?Visibility
    {
        return $this->visibility;
    }
}

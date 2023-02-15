<?php

namespace Manuskript\Fields;

class Select extends Field
{
    protected string $type = 'select';

    public function multiple(bool $boolean = true): self
    {
        return $this->decorate('multiple', $boolean);
    }

    public function searchable(bool $boolean = true): self
    {
        return $this->decorate('searchable', $boolean);
    }

    public function options($options): self
    {
        return $this->decorate(
            'options',
            is_array($options) || is_callable($options)
                ? $options
                : func_get_args()
        );
    }
}

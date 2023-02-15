<?php

namespace Manuskript\Fields;

class Repeat extends Field
{
    protected string $type = 'repeat';

    protected mixed $default = [];

    public function blocks($items)
    {
        return $this->decorate(
            'blocks',
            is_array($items) || is_callable($items)
                ? $items
                : func_get_args()
        );
    }
}

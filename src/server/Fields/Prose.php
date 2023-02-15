<?php

namespace Manuskript\Fields;

class Prose extends Field
{
    protected string $type = 'prose';

    protected mixed $default = [];

    public function toolbar($items): self
    {
        return $this->decorate(
            'toolbar',
            is_array($items) || is_callable($items)
                ? $items
                : func_get_args()
        );
    }

    public function blocks($items): self
    {
        return $this->decorate(
            'blocks',
            is_array($items) || is_callable($items)
                ? $items
                : func_get_args()
        );
    }

    public function allowRawEditing(bool|callable $boolean = true): self
    {
        return $this->decorate('raw', $boolean);
    }

    protected function booted(): void
    {
        $this->decorate('toolbar', [
            'h2', 'h3', 'bold', 'underline', 'italic', 'link', 'blockquote', 'bullet_list', 'ordered_list', 'horizontal_rule',
        ]);
    }
}

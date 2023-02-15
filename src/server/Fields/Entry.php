<?php

namespace Manuskript\Fields;

use InvalidArgumentException;
use Manuskript\Resource;

class Entry extends Field
{
    protected string $type = 'entry';

    public static function make($resource, $label = null, $name = null): static
    {
        if (!$resource instanceof Resource) {
            throw new InvalidArgumentException(sprintf(
                'Argument #1 ($resource) must be of type %s, %s given.',
                Resource::class,
                gettype($resource)
            ));
        }

        return parent::make($label ?? $resource::label(), $name)
            ->decorate('resource', $resource::slug());
    }

    public function columns($columns): self
    {
        return $this->decorate('columns', $columns);
    }

    public function title($title): self
    {
        return $this->columns([$title]);
    }
}

<?php

namespace Manuskript\Fields\Concerns;

enum Visibility: string
{
    case Index = 'index';
    case Show = 'show';
    case Edit = 'edit';

    public function equals(Visibility $visibility): bool
    {
        return $visibility === $this;
    }
}

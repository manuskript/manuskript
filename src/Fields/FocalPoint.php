<?php

namespace Manuskript\Fields;

class FocalPoint extends Field
{
    protected string $type = 'focal_point';

    public function image($url): self
    {
        return $this->decorate('image', $url);
    }
}

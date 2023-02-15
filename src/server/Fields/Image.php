<?php

namespace Manuskript\Fields;

class Image extends File
{
    protected string $type = 'image';

    public function focalPoint($label = 'Focal Point', $name = null): self
    {
        $focalPoint = FocalPoint::make($label, $name);

        return $this->decorate('focal_point', $focalPoint);
    }

    public function thumbnail($url): self
    {
        if (!$this->value) {
            return $this;
        }

        return $this->decorate(
            'thumbnail',
            is_callable($url)
                ? $url($this->value, $this->disk)
                : $url
        );
    }
}

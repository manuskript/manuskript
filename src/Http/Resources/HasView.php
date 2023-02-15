<?php

namespace Manuskript\Http\Resources;

trait HasView
{
    public ?string $view;

    public function view(string $view): self
    {
        $this->view = $view;

        return $this;
    }
}

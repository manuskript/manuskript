<?php

namespace Manuskript\Http\Resources;

trait HandlesFields
{
    protected ?array $fields = null;

    public function fields($fields)
    {
        $this->fields = $fields;

        return $this;
    }
}

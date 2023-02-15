<?php

namespace Manuskript\Http\Resources;

use Manuskript\Contracts\Arrayable;

trait HandlesFields
{
    protected ?array $fields = null;

    public function fields($fields)
    {
        if ($fields instanceof Arrayable) {
            $fields = $fields->toArray();
        }

        $this->fields = is_array($fields) ? $fields : [$fields];

        return $this;
    }
}

<?php

namespace Manuskript\Fields\Constraints;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Manuskript\Contracts\Arrayable;
use Manuskript\Fields\Field;

class Column implements Arrayable
{
    public function __construct(
        protected Field $field
    ) {}

    public function order($request = null)
    {
        $request ??= Container::getInstance()->make(Request::class);

        if (!$this->field->getAttribute('sortable', false)) {
            return false;
        }

        return $request->get('sortBy') === $this->field->getName()
            ? $request->get('dir', 'asc')
            : 'none';
    }

    public function toArray(): array
    {
        return [
            'label' => $this->field->getLabel(),
            'name' => $this->field->getName(),
            'order' => $this->order(),
        ];
    }
}

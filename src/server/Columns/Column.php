<?php

namespace Manuskript\Columns;

use JsonSerializable;
use Manuskript\Contracts\Arrayable;
use Manuskript\Contracts\Sortable;
use Manuskript\Fields\Field;

class Column implements Arrayable, JsonSerializable
{
    protected $order;

    public function __construct(
        protected Field $field
    ) {
    }

    public function field()
    {
        return $this->field;
    }

    public function order()
    {
        return $this->order;
    }

    public function setOrder($order)
    {
        return $this->order = $order;
    }

    public function __call($method, $args)
    {
        return call_user_func([$this->field, $method], $args);
    }

    public function sortable()
    {
        return $this->field instanceof Sortable
            && $this->field->isSortable();
    }

    public function instanceOf($class)
    {
        return $this->field instanceof $class;
    }

    public function toArray()
    {
        $array = [
            'label' => $this->field->getLabel(),
            'name' => $this->field->getName(),
            'type' => $this->field->getType(),
        ];

        if ($this->sortable()) {
            $array['order'] = $this->order() ?? 'none';
        }

        return $array;
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}

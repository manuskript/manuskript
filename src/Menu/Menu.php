<?php

namespace Manuskript\Menu;

use JsonSerializable;
use Manuskript\Contracts\Arrayable;

class Menu implements Arrayable, JsonSerializable
{
    public function __construct(
        protected string $label,
        protected array $items = []
    ) {}

    public function label()
    {
        return $this->label;
    }

    public function append(Item $item): void
    {
        $this->items[] = $item;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label(),
            'items' => $this->getItems(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}

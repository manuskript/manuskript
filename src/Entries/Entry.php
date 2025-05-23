<?php

namespace Manuskript\Entries;

use Manuskript\Fields\Field;

class Entry
{
    /**
     * @param Field[] $fields
     */
    public function __construct(
        private readonly mixed $key,
        private readonly array $fields,
    ) {
    }

    public function key(): mixed
    {
        return $this->key;
    }

    /**
     * @return Field[]
     */
    public function fields(): array
    {
        return $this->fields;
    }
}

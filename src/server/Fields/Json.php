<?php

namespace Manuskript\Fields;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Manuskript\Http\Request;
use Manuskript\Support\Collection;

class Json extends Field
{
    protected string $type = 'json';

    protected array $schema = [];

    protected array $public = [
        'name', 'label', 'type', 'value', 'default', 'decorators', 'visible', 'schema',
    ];

    public function schema(array|callable $schema): self
    {
        $rows = is_callable($schema)
            ? $schema(Container::getInstance()->make(Request::class))
            : $schema;

        $this->schema = Collection::make($rows)->keyBy->getName()->toArray();

        return $this;
    }

    public function hydrate(array|Model $values): void
    {
        parent::hydrate($values);

        $this->fillRow($values);
    }

    private function fillRow(array $values): void
    {
        foreach ($this->schema as $field) {
            $field->hydrate($values);
        }
    }
}

<?php

namespace Manuskript\Fields;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Manuskript\Fields\Concerns\ModifiesValueBeforeSave;
use RuntimeException;

class Repeat extends Field
{
    use ModifiesValueBeforeSave;

    protected string $type = 'repeat';

    protected $default = [];

    protected array $blocks;

    public function blocks($items): self
    {
        if(is_callable($items)) {
             $items = $items(Container::getInstance()->make(Request::class));
        }

        $this->blocks = is_array($items) ? $items : func_get_args();

        return $this;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'blocks' => $this->blocks,
        ]);
    }

    public function getValue(): array
    {
        $value = parent::getValue();

        if(is_string($value)) {
            $value = json_decode($value, true);
        }

        if(! is_array($value)) {
            throw new RuntimeException(sprintf(
                'The value must be of type array, $s given',
                gettype($value),
            ));
        }

        return $value;
    }

    protected function booting(): void
    {
        $this->showOnIndex(false);
        $this->showOnShow(true);
        $this->showOnEdit(true);
        $this->showOnCreate(true);
    }
}

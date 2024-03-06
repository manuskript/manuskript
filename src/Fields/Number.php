<?php

namespace Manuskript\Fields;

use InvalidArgumentException;
use Manuskript\Fields\Concerns\ModifiesValueBeforeSave;
use Manuskript\Fields\Concerns\Sortable;

class Number extends Field
{
    use Sortable;
    use ModifiesValueBeforeSave;

    protected string $type = 'number';

    protected array $rules = ['numeric'];

    public function min($value): self
    {
        $this->throwIfNotNumeric($value);

        return $this->setAttribute('min', $value)
            ->addRules("min:$value");
    }

    public function max($value): self
    {
        $this->throwIfNotNumeric($value);

        return $this->setAttribute('max', $value)
            ->addRules("max:$value");
    }

    public function step($value): self
    {
        $this->throwIfNotNumeric($value);

        $this->attributes['step'] = $value;

        return $this;
    }

    protected function booting(): void
    {
        $this->showOnShow(true);
        $this->showOnEdit(true);
        $this->showOnCreate(true);
    }

    private function throwIfNotNumeric($number): void
    {
        if(! is_numeric($number)) {
            throw new InvalidArgumentException(sprintf(
                '$field must be a numeric type, %s: %s given',
                gettype($number),
                (string) $number
            ));
        }
    }
}

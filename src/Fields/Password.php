<?php

namespace Manuskript\Fields;

use Illuminate\Support\Facades\Hash;
use Manuskript\Fields\Concerns\ModifiesValueBeforeSave;
use Manuskript\Fields\Concerns\Sortable;

class Password extends Field
{
    use Sortable;
    use ModifiesValueBeforeSave;

    protected string $type = 'password';

    public static function make($label = 'Password', $name = null): static
    {
        return parent::make($label, $name);
    }

    public function toModelAttribute(): mixed
    {
        if(isset(static::$saveUsing)) {
            $modifier = static::$saveUsing;

            return $modifier($this->getRawValue());
        }

        return Hash::make($this->getRawValue());
    }

    public function getValue(): mixed
    {
        return '';
    }
}

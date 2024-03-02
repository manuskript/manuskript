<?php

namespace Manuskript\Fields;

use Carbon\Carbon;
use Manuskript\Fields\Concerns\ModifiesValueBeforeSave;
use Manuskript\Fields\Concerns\Sortable;

class Date extends Field
{
    use Sortable;
    use ModifiesValueBeforeSave;

    protected string $type = 'date';

    public function getValue(): mixed
    {
        $value = parent::getValue();

        if(is_null($value)) {
            return $value;
        }

        return Carbon::parse($value)->format('Y-m-d');
    }
}

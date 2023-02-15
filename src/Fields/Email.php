<?php

namespace Manuskript\Fields;

use Manuskript\Fields\Concerns\ModifiesValueBeforeSave;
use Manuskript\Fields\Concerns\Sortable;

class Email extends Field
{
    use Sortable;
    use ModifiesValueBeforeSave;

    protected string $type = 'email';

    public static function make($label = 'E-Mail', $name = 'email'): static
    {
        return parent::make($label, $name);
    }

    protected function booting()
    {
        $this->showOnShow(true);
        $this->showOnEdit(true);
        $this->showOnCreate(true);
    }
}

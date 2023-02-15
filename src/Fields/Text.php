<?php

namespace Manuskript\Fields;

use Manuskript\Fields\Concerns\ModifiesValueBeforeSave;
use Manuskript\Fields\Concerns\Sortable;

class Text extends Field
{
    use Sortable;
    use ModifiesValueBeforeSave;

    protected function booting()
    {
        $this->showOnShow(true);
        $this->showOnEdit(true);
        $this->showOnCreate(true);
    }
}

<?php

namespace Manuskript\Tests\stubs\Fields;

use Manuskript\Fields\Field;

class HydratingHookField extends Field
{
    protected string $type = 'foo';

    protected function hydrating($value): void
    {
        $value->setValue('updated from hook');
    }
}

<?php

namespace Manuskript\Actions;

use Manuskript\Action;
use Manuskript\Facades\Entries;
use Manuskript\Http\Request;

class Destroy extends Action
{
    protected static ?string $label = 'Delete';

    protected static ?string $name = 'destroy';

    protected static string $level = 'danger';

    protected function handle(Request $request): void
    {
        Entries::delete($request->models, $this->resource);
    }
}

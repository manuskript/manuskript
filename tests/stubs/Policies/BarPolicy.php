<?php

namespace Manuskript\Tests\stubs\Policies;

use Illuminate\Http\Request;
use Manuskript\Policies\Policy;

class BarPolicy extends Policy
{
    public function delete(Request $request): bool
    {
        return false;
    }
}

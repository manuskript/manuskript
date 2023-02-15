<?php

namespace Manuskript\Policies;

use Illuminate\Http\Request;

class Policy
{
    public function view(Request $request): bool
    {
        return true;
    }

    public function viewAny(Request $request): bool
    {
        return true;
    }

    public function create(Request $request): bool
    {
        return true;
    }

    public function update(Request $request): bool
    {
        return true;
    }

    public function delete(Request $request): bool
    {
        return true;
    }

    public function restore(Request $request): bool
    {
        return true;
    }
}

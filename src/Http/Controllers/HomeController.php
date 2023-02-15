<?php

namespace Manuskript\Http\Controllers;

use Inertia\Inertia;

class HomeController
{
    public function __invoke()
    {
        return Inertia::render('Home');
    }
}

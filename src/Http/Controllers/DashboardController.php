<?php

namespace Manuskript\Http\Controllers;

use Manuskript\Http\Response;

class DashboardController
{
    public function __invoke()
    {
        return Response::make('Home');
    }
}

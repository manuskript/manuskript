<?php

namespace Manuskript\Http\Controllers;

use Manuskript\Http\Response;

class DashboardController
{
    public function __invoke(): Response
    {
        return Response::make('Home');
    }
}

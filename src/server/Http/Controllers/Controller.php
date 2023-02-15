<?php

namespace Manuskript\Http\Controllers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;
use Manuskript\Exceptions\AccessDeniedHttpException;
use Manuskript\Exceptions\Handler;
use Manuskript\Http\Middleware\Authorize;
use Manuskript\Manuskript;

class Controller extends BaseController
{
    public function __construct()
    {
        $this->middleware(Authorize::class);

        App::singleton(ExceptionHandler::class, Handler::class);
    }

    protected function authorize($scope, $resource)
    {
        if (!Manuskript::can($scope, $resource)) {
            throw new AccessDeniedHttpException();
        }
    }
}

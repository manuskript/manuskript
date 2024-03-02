<?php

namespace Manuskript\Http\Controllers\Concerns;

use Manuskript\Auth\Guard;
use Manuskript\Policies\Policy;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

trait AuthorizeRequest
{
    protected function authorize(string $abillity, string|Policy $policy): void
    {
        if(! Guard::isAuthorized($abillity, $policy)) {
            throw new AccessDeniedHttpException();
        }
    }
}

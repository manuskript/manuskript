<?php

namespace Manuskript\Auth;

class Authorize
{
    public function handle($request): bool
    {
        return false;
    }

    public function __invoke($request): bool
    {
        return $this->handle($request);
    }
}

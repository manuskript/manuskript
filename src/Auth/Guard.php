<?php

namespace Manuskript\Auth;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Manuskript\Policies\Policy;

class Guard
{
    public function __construct(
        private readonly Policy $policy
    ) {}

    public function canView(Request $request): bool
    {
        return static::isAuthorized('view', $this->policy, $request);
    }

    public function canViewAny(Request $request): bool
    {
        return static::isAuthorized('viewAny', $this->policy, $request);
    }

    public function canCreate(Request $request): bool
    {
        return static::isAuthorized('create', $this->policy, $request);
    }

    public function canUpdate(Request $request): bool
    {
        return static::isAuthorized('update', $this->policy, $request);
    }

    public function canDelete(Request $request): bool
    {
        return static::isAuthorized('delete', $this->policy, $request);
    }

    public function canRestore(Request $request): bool
    {
        return static::isAuthorized('restore', $this->policy, $request);
    }

    public static function isAuthorized($method, string|Policy $policy, Request $request = null)
    {
        $policy = is_string($policy) ? new $policy() : $policy;

        return call_user_func([$policy, $method], $request ?? Container::getInstance()->make(Request::class));
    }
}

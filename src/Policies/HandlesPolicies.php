<?php

namespace Manuskript\Policies;

use Illuminate\Http\Request;

trait HandlesPolicies
{
    protected static ?string $policy;

    public static function canView(Request $request): bool
    {
        return static::fromPolicy('view', $request);
    }

    public static function canViewAny(Request $request): bool
    {
        return static::fromPolicy('viewAny', $request);
    }

    public static function canCreate(Request $request): bool
    {
        return static::fromPolicy('create', $request);
    }

    public static function canUpdate(Request $request): bool
    {
        return static::fromPolicy('update', $request);
    }

    public static function canDelete(Request $request): bool
    {
        return static::fromPolicy('delete', $request);
    }

    public static function canRestore(Request $request): bool
    {
        return static::fromPolicy('restore', $request);
    }

    protected static function policy()
    {
        if (isset(static::$policy)) {
            return new static::$policy();
        }

        return new Policy();
    }

    protected static function fromPolicy($method, Request $request)
    {
        return call_user_func([static::policy(), $method], $request);
    }
}

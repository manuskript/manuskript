<?php

namespace Manuskript;

use Composer\InstalledVersions;

class Manuskript
{
    public static function version(): ?string
    {
        return InstalledVersions::getVersion(
            'manuskript/manuskript',
        );
    }

    public static function register(Resources\Resource $resource): void
    {
        Facades\Resource::register($resource);
    }
}

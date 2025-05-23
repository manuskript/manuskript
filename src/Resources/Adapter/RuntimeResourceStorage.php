<?php

namespace Manuskript\Resources\Adapter;

use ArrayAccess;
use Illuminate\Support;
use Manuskript\Resources\Resource;

/**
 * @implements ArrayAccess<string, Resource>
 * @implements Support\Enumerable<string, Resource>
 * @template-extends Support\Collection<array-key,Resource>
 */
class RuntimeResourceStorage extends Support\Collection
{
}

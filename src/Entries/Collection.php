<?php

namespace Manuskript\Entries;

use ArrayAccess;
use Illuminate\Support;

/**
 * @implements ArrayAccess<array-key, Entry>
 * @implements Support\Enumerable<array-key, Entry>
 * @template-extends Support\Collection<array-key,Entry>
 */
class Collection extends Support\Collection
{
    //
}

<?php

namespace Manuskript\Entries;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Manuskript\Entries\Concerns\Context;
use Manuskript\Resources\Resource;

interface EntryRepository
{
    public function collection(Resource $resource, ?Context $context = null, string $cursor = null): CursorPaginator;
    public function find(Resource $resource, string|int $key, ?Context $context = null): Entry;
}

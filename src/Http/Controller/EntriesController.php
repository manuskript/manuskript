<?php

namespace Manuskript\Http\Controller;

use Manuskript\Entries\Concerns\Context;
use Manuskript\Entries\EntryRepository;

class EntriesController
{
    public function __construct(
        private readonly EntryRepository $entries
    ) {
    }

    public function index($resource)
    {
        $data = $this->entries->collection($resource, Context::Index);
    }
}

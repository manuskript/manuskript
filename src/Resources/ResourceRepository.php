<?php

namespace Manuskript\Resources;

interface ResourceRepository
{
    public function resolve(string $key): Resource;

    public function register(Resource $resource): void;
}

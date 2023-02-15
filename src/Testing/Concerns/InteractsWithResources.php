<?php

namespace Manuskript\Testing\Concerns;

use Manuskript\Manuskript;

trait InteractsWithResources
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->resetRegisteredResources();
    }

    protected function resetRegisteredResources()
    {
        Manuskript::$resources = [];
    }
}

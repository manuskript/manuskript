<?php

namespace Manuskript\Exceptions;

use LogicException;
use Spatie\Ignition\Contracts as Ignition;

class UnresolvableResourceException extends LogicException implements Ignition\ProvidesSolution
{
    public function getSolution(): Ignition\Solution
    {
        return Ignition\BaseSolution::create('Resource not found.')
            ->setSolutionDescription(sprintf('Did you register the resource in your "App\Providers\ManuskriptServiceProvider" class?'))
            ->setDocumentationLinks([
                'Docs: Creating Resources' => 'https://manuskript.dev/docs/resources',
            ]);
    }
}

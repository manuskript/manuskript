<?php

namespace Manuskript\Entries\Concerns;

enum Context: string
{
    case Index = 'index';
    case Show = 'show';
    case Edit = 'edit';
}

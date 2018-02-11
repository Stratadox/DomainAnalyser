<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit\Double;

use Stratadox\ImmutableCollection\ImmutableCollection;

class Foos extends ImmutableCollection
{
    public function __construct(Foo ...$foos)
    {
        parent::__construct(...$foos);
    }
}

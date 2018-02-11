<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Feature\Double\FooBar;

class Bar
{
    private $bar;

    public function __construct(string $bar)
    {
        $this->bar = $bar;
    }
}

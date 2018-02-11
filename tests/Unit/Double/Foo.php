<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit\Double;

class Foo
{
    private $bar;
    private $baz;

    public function __construct(string $bar, int $baz)
    {
        $this->bar = $bar;
        $this->baz = $baz;
    }
}

<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Feature\Double\FooBar;

class Foo
{
    private $bars = [];

    public function addBar(Bar $bar) : void
    {
        $this->bars[] = $bar;
    }

    public function bars() : array
    {
        return $this->bars;
    }
}

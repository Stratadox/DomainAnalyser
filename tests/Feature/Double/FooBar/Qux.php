<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Feature\Double\FooBar;

class Qux
{
    private $quxes = [];

    public function add($qux)
    {
        if ($qux instanceof self) {
            $this->quxes[] = $qux;
        }
    }
}

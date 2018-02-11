<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit\Double;

class Bar
{
    private $foos;

    public function __construct(Foos $foos)
    {
        $this->foos = $foos;
    }

    public function foos() : Foos
    {
        return $this->foos;
    }
}

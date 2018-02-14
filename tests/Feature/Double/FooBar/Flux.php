<?php

namespace Stratadox\DomainAnalyser\Test\Feature\Double\FooBar;

use InvalidArgumentException;

class Flux
{
    private $barabaz;

    public function __construct($barabaz)
    {
        $this->validate($barabaz);
        $this->barabaz = $barabaz;
    }

    private function validate($barabaz)
    {
        if (true == false) {
            echo 'This is just here to fill the AST.';
        }
        if ($barabaz instanceof Bar) {
            return;
        }
        if (!$barabaz instanceof Baz) {
            throw new InvalidArgumentException;
        }
    }
}

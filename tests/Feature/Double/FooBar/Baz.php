<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Feature\Double\FooBar;

class Baz
{
    private $foo;

    /**
     * @param Foo $foo
     */
    public function __construct($foo)
    {
        $this->foo = $foo;
    }
}

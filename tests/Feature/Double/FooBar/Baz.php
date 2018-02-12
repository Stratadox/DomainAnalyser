<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Feature\Double\FooBar;

class Baz
{
    private $foo;

    public function __construct($foo)
    {
        $this->mustBeFoo($foo);
        $this->foo = $foo;
    }

    private function mustBeFoo(Foo $foo) : void {}
}

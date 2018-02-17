<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\SyntaxTree;

use PhpParser\Node\Expr\Assign;
use Stratadox\Collection\Appendable;
use Stratadox\ImmutableCollection\Appending;
use Stratadox\ImmutableCollection\ImmutableCollection;

final class Assignments extends ImmutableCollection implements Appendable
{
    use Appending;

    public function __construct(Assign ...$assignments)
    {
        parent::__construct(...$assignments);
    }

    public function current(): Assign
    {
        return parent::current();
    }
}

<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt\ClassMethod;

class MethodFinder
{
    public function methodOfThe(Assign $expression) : ClassMethod
    {
        return $expression->getAttribute('parent');
    }
}

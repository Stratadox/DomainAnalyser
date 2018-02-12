<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt\ClassMethod;

class MethodFinder
{
    public function methodOfThe(Assign $expression) : ClassMethod
    {
        do {
            $expression = $expression->getAttribute('parent');
        } while (!$expression instanceof ClassMethod);

        return $expression;
    }
}

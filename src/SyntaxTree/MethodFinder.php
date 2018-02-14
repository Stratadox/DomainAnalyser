<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\SyntaxTree;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt\ClassMethod;

class MethodFinder
{
    public function methodOfThe(Assign $expression) : ClassMethod
    {
        do {
            $expression = $expression->getAttribute('parent');
            if (!isset($expression)) {
                throw new MethodNotFound;
            }
        } while (!$expression instanceof ClassMethod);

        return $expression;
    }
}

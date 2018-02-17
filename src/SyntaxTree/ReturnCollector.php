<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\SyntaxTree;

use PhpParser\Node;
use PhpParser\Node\Stmt\Return_ as ReturnStatement;
use PhpParser\NodeVisitorAbstract;

final class ReturnCollector extends NodeVisitorAbstract
{
    private $statements;

    public function leaveNode(Node $node): void
    {
        if ($node instanceof ReturnStatement) {
            $this->statements[] = $node;
        }
    }

    public function statements(): array
    {
        return $this->statements;
    }
}

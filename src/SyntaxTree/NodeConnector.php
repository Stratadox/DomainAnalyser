<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\SyntaxTree;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class NodeConnector extends NodeVisitorAbstract
{
    private $stack;
    /** @var Node */
    private $prev;

    public function beforeTraverse(array $nodes)
    {
        $this->stack = [];
        $this->prev = null;
    }

    public function enterNode(Node $node)
    {
        if (!empty($this->stack)) {
            $node->setAttribute('parent', $this->stack[count($this->stack) - 1]);
        }
        if ($this->prev && $this->hasSameParentAsPrevious($node)) {
            $node->setAttribute('prev', $this->prev);
            $this->prev->setAttribute('next', $node);
        }
        $this->stack[] = $node;
    }

    public function leaveNode(Node $node)
    {
        $this->prev = $node;
        array_pop($this->stack);
    }

    private function hasSameParentAsPrevious(Node $node)
    {
        return $this->prev->getAttribute('parent') === $node->getAttribute('parent');
    }
}

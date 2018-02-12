<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign as Assignment;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\NodeVisitorAbstract;

class AssignmentCollector extends NodeVisitorAbstract
{
    private $assignments = [];

    public function leaveNode(Node $currentNode)
    {
        if ($currentNode instanceof Assignment) {
            $this->registerAssignment($currentNode);
        }
    }

    private function registerAssignment(Assignment $node)
    {
        if (!$node->var instanceof PropertyFetch) {
            return;
        }
        if (!$this->isOwnProperty($node->var)) {
            return;
        }
        $this->assignments[] = $node;
    }

    public function assignments() : array
    {
        return $this->assignments;
    }

    private function isOwnProperty(PropertyFetch $property)
    {
        return ($property->var instanceof Variable && $property->var->name === 'this');
    }
}

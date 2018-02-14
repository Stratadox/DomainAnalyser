<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\SyntaxTree;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign as Assignment;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\NodeVisitorAbstract;

class AssignmentCollector extends NodeVisitorAbstract
{
    private $assignments;

    public function __construct()
    {
        $this->assignments = new Assignments;
    }

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
        $this->assignments = $this->assignments->add($node);
    }

    public function assignments() : Assignments
    {
        return $this->assignments;
    }

    private function isOwnProperty(PropertyFetch $property)
    {
        return $property->var instanceof Variable
            && $this->appliesToMe($property->var);
    }

    private function appliesToMe(Variable $assignment)
    {
        return $assignment->name === 'this';
    }
}

<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit\SyntaxTree;

use PhpParser\Node\Expr\Variable;
use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\SyntaxTree\DownToTheRoot;

/**
 * @covers \Stratadox\DomainAnalyser\SyntaxTree\DownToTheRoot
 */
class DownToTheRoot_traverses_down_from_a_starting_node extends TestCase
{
    /** @test */
    function traversing_through_all_the_previous_nodes()
    {
        $node[2] = new Variable('foo');
        $node[1] = new Variable('foo', ['prev' => $node[2]]);
        $node[0] = new Variable('foo', ['prev' => $node[1]]);

        $traversal = DownToTheRoot::startingAt($node[0]);

        $this->assertCount(3, $traversal);

        foreach ($traversal as $atCurrentIndex => $actualNode) {
            $this->assertSame($node[$atCurrentIndex], $actualNode);
        }
    }

    /** @test */
    function asking_the_parent_when_out_of_siblings()
    {
        $node[4] = new Variable('foo');
        $node[3] = new Variable('foo', ['prev' => $node[4]]);
        $node[2] = new Variable('foo', ['parent' => $node[3]]);
        $node[1] = new Variable('foo', ['prev' => $node[2]]);
        $node[0] = new Variable('foo', ['prev' => $node[1]]);

        $traversal = DownToTheRoot::startingAt($node[0]);

        $this->assertCount(5, $traversal);

        foreach ($traversal as $atCurrentIndex => $actualNode) {
            $this->assertSame($node[$atCurrentIndex], $actualNode);
        }
    }
}

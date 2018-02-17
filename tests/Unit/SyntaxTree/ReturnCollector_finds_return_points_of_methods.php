<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit\SyntaxTree;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Stmt\Return_;
use PHPUnit\Framework\TestCase as Test;
use Stratadox\DomainAnalyser\SyntaxTree\ReturnCollector;

/**
 * @covers \Stratadox\DomainAnalyser\SyntaxTree\ReturnCollector
 */
class ReturnCollector_finds_return_points_of_methods extends Test
{
    /** @test */
    function finding_return_statements()
    {
        $collector = new ReturnCollector;

        $return1 = new Return_();
        $assignment = new Assign(
            new Variable('foo'),
            new LNumber(1)
        );
        $return2 = new Return_(new Variable('foo'));

        $collector->leaveNode($return1);
        $collector->leaveNode($assignment);
        $collector->leaveNode($return2);

        Test::assertCount(2, $collector->statements());
        Test::assertEquals($return1, $collector->statements()[0]);
        Test::assertEquals($return2, $collector->statements()[1]);
    }
}

<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\LNumber;
use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\AssignmentCollector;

/**
 * @covers \Stratadox\DomainAnalyser\AssignmentCollector
 */
class AssignmentCollector_finds_where_properties_get_assigned extends TestCase
{
    /** @test */
    function keeping_track_of_property_assignments()
    {
        $collector = new AssignmentCollector;

        $assign = new Assign(
            new PropertyFetch(new Variable('this'), 'foo'),
            new Variable('bar')
        );

        $collector->leaveNode($assign);

        $this->assertSame(
            [$assign],
            $collector->assignments()
        );
    }

    /** @test */
    function keeping_track_of_multiple_property_assignments()
    {
        $collector = new AssignmentCollector;

        $assignFoo = new Assign(
            new PropertyFetch(new Variable('this'), 'foo'),
            new Variable('foo')
        );

        $assignBar = new Assign(
            new PropertyFetch(new Variable('this'), 'bar'),
            new Variable('bar')
        );

        $collector->leaveNode($assignFoo);
        $collector->leaveNode($assignBar);

        $this->assertSame(
            [$assignFoo, $assignBar],
            $collector->assignments()
        );
    }

    /** @test */
    function only_keeping_track_of_property_assignments()
    {
        $collector = new AssignmentCollector;

        $assignLocalVar = new Assign(
            new Variable('foo'),
            new LNumber(1)
        );
        $assignFooProperty = new Assign(
            new PropertyFetch(new Variable('this'), 'foo'),
            new Variable('foo')
        );
        $functionCall = new FuncCall(new Name('doSomething'));

        $collector->leaveNode($assignLocalVar);
        $collector->leaveNode($assignFooProperty);
        $collector->leaveNode($functionCall);

        $this->assertSame(
            [$assignFooProperty],
            $collector->assignments()
        );
    }
}

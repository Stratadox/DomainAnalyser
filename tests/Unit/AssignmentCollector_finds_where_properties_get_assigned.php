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
use Stratadox\DomainAnalyser\Assignments;

/**
 * @covers \Stratadox\DomainAnalyser\AssignmentCollector
 */
class AssignmentCollector_finds_where_properties_get_assigned extends TestCase
{
    /** @test */
    function keeping_track_of_property_assignments()
    {
        $collector = new AssignmentCollector;

        $assignment = new Assign(
            new PropertyFetch(new Variable('this'), 'foo'),
            new Variable('bar')
        );

        $collector->leaveNode($assignment);

        $this->assertEquals(
            new Assignments($assignment),
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

        $this->assertEquals(
            new Assignments($assignFoo, $assignBar),
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

        $this->assertEquals(
            new Assignments($assignFooProperty),
            $collector->assignments()
        );
    }

    /** @test */
    function only_keeping_track_of_own_property_assignments()
    {
        $collector = new AssignmentCollector;

        $assignThisFoo = new Assign(
            new PropertyFetch(new Variable('this'), 'foo'),
            new Variable('foo')
        );
        $assignThatFoo = new Assign(
            new PropertyFetch(new Variable('that'), 'foo'),
            new Variable('foo')
        );

        $collector->leaveNode($assignThisFoo);
        $collector->leaveNode($assignThatFoo);

        $this->assertEquals(
            new Assignments($assignThisFoo),
            $collector->assignments()
        );
    }
}

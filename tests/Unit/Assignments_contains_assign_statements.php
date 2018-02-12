<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\Assignments;

/**
 * @covers \Stratadox\DomainAnalyser\Assignments
 */
class Assignments_contains_assign_statements extends TestCase
{
    /** @test */
    function iterating_through_assignments()
    {
        $assignments = new Assignments(
            new Assign(
                new PropertyFetch(new Variable('this'), 'foo'),
                new Variable('foo')
            ),
            new Assign(
                new PropertyFetch(new Variable('this'), 'bar'),
                new Variable('bar')
            )
        );

        $this->assertCount(2, $assignments);
        foreach ($assignments as $assignment) {
            $this->assertInstanceOf(Assign::class, $assignment);
        }
    }

    /** @test */
    function adding_assignments_to_the_collection()
    {
        $assignments = new Assignments(
            new Assign(
                new PropertyFetch(new Variable('this'), 'foo'),
                new Variable('foo')
            ),
            new Assign(
                new PropertyFetch(new Variable('this'), 'bar'),
                new Variable('bar')
            )
        );

        $assignments = $assignments->add(new Assign(
            new PropertyFetch(new Variable('this'), 'bar'),
            new Variable('newBar')
        ));

        $this->assertCount(3, $assignments);
    }
}

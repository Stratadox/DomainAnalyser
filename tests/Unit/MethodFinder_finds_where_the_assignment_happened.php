<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\MethodFinder;

/**
 * @covers \Stratadox\DomainAnalyser\MethodFinder
 */
class MethodFinder_finds_where_the_assignment_happened extends TestCase
{
    /** @test */
    function finding_the_method_for_a_simple_setter()
    {
        $method = new ClassMethod('foo', [
            'params' => [
                new Param('foo', null, 'string')
            ],
            'stmts' => [
                $assignment = new Assign(
                    new PropertyFetch(new Variable('this'), 'foo'),
                    new Variable('foo')
                )
            ]
        ]);

        $assignment->setAttribute('parent', $method);

        $finder = new MethodFinder;

        $this->assertSame($method, $finder->methodOfThe($assignment));
    }
}

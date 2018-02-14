<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit\SyntaxTree;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\If_;
use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\SyntaxTree\MethodFinder;
use Stratadox\DomainAnalyser\SyntaxTree\MethodNotFound;

/**
 * @covers \Stratadox\DomainAnalyser\SyntaxTree\MethodFinder
 * @covers \Stratadox\DomainAnalyser\SyntaxTree\MethodNotFound
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

    /** @test */
    function finding_the_method_when_in_a_condition()
    {
        $method = new ClassMethod('foo', [
            'params' => [
                new Param('foo', null, 'string')
            ],
            'stmts' => [
                $condition = new If_(new LNumber(1), [
                    'stmts' => [
                        $assignment = new Assign(
                            new PropertyFetch(new Variable('this'), 'foo'),
                            new Variable('foo')
                        )
                    ]
                ])
            ]
        ]);

        $assignment->setAttribute('parent', $condition);
        $condition->setAttribute('parent', $method);

        $finder = new MethodFinder;

        $this->assertSame($method, $finder->methodOfThe($assignment));
    }

    /** @test */
    function throwing_an_exception_when_not_in_a_method()
    {
        $assignment = new Assign(
            new PropertyFetch(new Variable('this'), 'foo'),
            new Variable('foo')
        );

        $finder = new MethodFinder;

        $this->expectException(MethodNotFound::class);
        $finder->methodOfThe($assignment);
    }
}

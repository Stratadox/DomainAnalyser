<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit\SyntaxTree;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\SyntaxTree\NodeConnector;

/**
 * @covers \Stratadox\DomainAnalyser\SyntaxTree\NodeConnector
 */
class NodeConnector_adds_parental_and_sibling_relationships extends TestCase
{
    /** @test */
    function foo()
    {
        $method = new ClassMethod('setFoo', [
            'params' => [
                new Param('foo', null, 'string')
            ],
            'stmts' => [
                $assignFoo = new Assign(
                    new PropertyFetch(new Variable('this'), 'foo'),
                    new Variable('foo')
                ),
                $assignBar = new Assign(
                    new PropertyFetch(new Variable('this'), 'bar'),
                    new Variable('bar')
                ),
            ]
        ]);

        $this->assertNull($assignFoo->getAttribute('parent'));
        $this->assertNull($assignFoo->getAttribute('prev'));
        $this->assertNull($assignFoo->getAttribute('next'));
        $this->assertNull($assignBar->getAttribute('parent'));
        $this->assertNull($assignBar->getAttribute('prev'));
        $this->assertNull($assignBar->getAttribute('next'));

        $connector = new NodeConnector;
        $connector->beforeTraverse([]);
        $connector->enterNode($method);
        $connector->enterNode($assignFoo);
        $connector->leaveNode($assignFoo);
        $connector->enterNode($assignBar);
        $connector->leaveNode($assignBar);
        $connector->leaveNode($method);
        $connector->afterTraverse([]);

        $this->assertSame($method, $assignFoo->getAttribute('parent'));
        $this->assertSame($method, $assignBar->getAttribute('parent'));
        $this->assertNull($assignFoo->getAttribute('prev'));
        $this->assertSame($assignBar, $assignFoo->getAttribute('next'));
        $this->assertSame($assignFoo, $assignBar->getAttribute('prev'));
        $this->assertNull($assignBar->getAttribute('next'));
    }
}

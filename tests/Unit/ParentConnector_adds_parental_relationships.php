<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\ParentConnector;

/**
 * @covers \Stratadox\DomainAnalyser\ParentConnector
 */
class ParentConnector_adds_parental_relationships extends TestCase
{
    /** @test */
    function foo()
    {
        $method = new ClassMethod('setFoo', [
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

        $this->assertNull($assignment->getAttribute('parent'));

        $connector = new ParentConnector;
        $connector->beforeTraverse([]);
        $connector->enterNode($method);
        $connector->enterNode($assignment);
        $connector->leaveNode($assignment);
        $connector->leaveNode($method);

        $this->assertSame($method, $assignment->getAttribute('parent'));
    }
}

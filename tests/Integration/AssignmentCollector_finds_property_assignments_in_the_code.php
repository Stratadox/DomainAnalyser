<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Integration;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\AssignmentCollector;
use Stratadox\DomainAnalyser\Assignments;

/**
 * @coversNothing
 */
class AssignmentCollector_finds_property_assignments_in_the_code extends TestCase
{
    /** @test */
    function collecting_a_bunch_of_assignments_in_a_class()
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $traverser = new NodeTraverser;
        $collector = new AssignmentCollector;

        $code = '<?php
        class Foo {
            private $foo;
            private $bar;
            
            public function __construct(string $foo, string $andBar) {
                $this->foo = $foo;
                $this->bar = $andBar;
            }
        }';

        $line7 = [
            'startLine' => 7,
            'endLine' => 7,
        ];
        $line8 = [
            'startLine' => 8,
            'endLine' => 8,
        ];

        $traverser->addVisitor($collector);
        $traverser->traverse($parser->parse($code));


        $this->assertEquals(
            new Assignments(
                new Assign(
                    new PropertyFetch(new Variable('this', $line7), 'foo', $line7),
                    new Variable('foo', $line7),
                    $line7
                ),
                new Assign(
                    new PropertyFetch(new Variable('this', $line8), 'bar', $line8),
                    new Variable('andBar', $line8),
                    $line8
                )
            ),
            $collector->assignments()
        );
   }
}

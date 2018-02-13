<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Integration;

use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\AssignmentCollector;
use Stratadox\DomainAnalyser\MethodFinder;
use Stratadox\DomainAnalyser\NodeConnector;

/**
 * @coversNothing
 */
class MethodFinder_locates_state_changing_methods extends TestCase
{
    /** @test */
    function figuring_out_which_method_assigns_to_properties()
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $traverser = new NodeTraverser;
        $collector = new AssignmentCollector;
        $connector = new NodeConnector;
        $finder = new MethodFinder;

        $code = '<?php
        class Foo {
            private $foo;
            private $bar;
            
            public function __construct(string $foo, string $bar)
            {
                $this->foo = $foo;
                $this->bar = $bar;
            }
            
            public function foo() : string
            {
                return $this->foo;
            }
            
            public function bar() : string
            {
                return $this->bar;
            }
            
            public function setFoo(string $foo)
            {
                $this->foo = $foo;
            }
            
            public function setBar(string $bar)
            {
                $this->bar = $bar;
            }
        }';

        $traverser->addVisitor($collector);
        $traverser->addVisitor($connector);
        $traverser->traverse($parser->parse($code));

        $assignments = $collector->assignments();

        $this->assertCount(4, $assignments);

        $this->assertEquals(
            '__construct',
            $finder->methodOfThe($assignments[0])->name
        );
        $this->assertEquals(
            '__construct',
            $finder->methodOfThe($assignments[1])->name
        );
        $this->assertEquals(
            'setFoo',
            $finder->methodOfThe($assignments[2])->name
        );
        $this->assertEquals(
            'setBar',
            $finder->methodOfThe($assignments[3])->name
        );
    }
}

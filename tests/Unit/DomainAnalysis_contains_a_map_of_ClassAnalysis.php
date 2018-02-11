<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\ClassAnalysis;
use Stratadox\DomainAnalyser\DomainAnalysis;
use Stratadox\DomainAnalyser\PropertyAnalysis;
use Stratadox\DomainAnalyser\Test\Unit\Double\Bar;
use Stratadox\DomainAnalyser\Test\Unit\Double\Foo;
use Stratadox\DomainAnalyser\Test\Unit\Double\Foos;

/**
 * @covers \Stratadox\DomainAnalyser\DomainAnalysis
 */
class DomainAnalysis_contains_a_map_of_ClassAnalysis extends TestCase
{
    /** @test */
    function retrieving_class_analysis_by_name()
    {
        $fooAnalysis = ClassAnalysis::with([
            'bar' => PropertyAnalysis::forType('string'),
            'baz' => PropertyAnalysis::forType('int'),
        ]);
        $barAnalysis = ClassAnalysis::with([
            'foos' => PropertyAnalysis::forCollection(Foos::class, Foo::class),
        ]);

        $domainAnalysis = DomainAnalysis::with([
            Foo::class => $fooAnalysis,
            Bar::class => $barAnalysis,
        ]);

        $this->assertSame(
            $fooAnalysis,
            $domainAnalysis->ofThe(Foo::class)
        );
        $this->assertSame(
            $barAnalysis,
            $domainAnalysis->ofThe(Bar::class)
        );
    }
}

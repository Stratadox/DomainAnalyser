<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit\Analysis;

use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\Analysis\Properties;
use Stratadox\DomainAnalyser\Analysis\Domain;
use Stratadox\DomainAnalyser\Analysis\Property;
use Stratadox\DomainAnalyser\Test\Unit\Double\Bar;
use Stratadox\DomainAnalyser\Test\Unit\Double\Foo;
use Stratadox\DomainAnalyser\Test\Unit\Double\Foos;

/**
 * @covers \Stratadox\DomainAnalyser\Analysis\Domain
 */
class Domain_has_Properties_per_class extends TestCase
{
    /** @test */
    function retrieving_class_analysis_by_name()
    {
        $fooAnalysis = Properties::with([
            'bar' => Property::forType('string'),
            'baz' => Property::forType('int'),
        ]);
        $barAnalysis = Properties::with([
            'foos' => Property::forCollection(Foos::class, Foo::class),
        ]);

        $domainAnalysis = Domain::with([
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

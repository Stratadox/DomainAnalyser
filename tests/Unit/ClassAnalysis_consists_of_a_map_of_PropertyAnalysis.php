<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\ClassAnalysis;
use Stratadox\DomainAnalyser\PropertyAnalysis;

/**
 * @covers \Stratadox\DomainAnalyser\ClassAnalysis
 */
class ClassAnalysis_consists_of_a_map_of_PropertyAnalysis extends TestCase
{
    /** @test */
    function retrieving_property_analysis_by_name()
    {
        $barProperty = PropertyAnalysis::forType('string');
        $bazProperty = PropertyAnalysis::forType('int');

        $classAnalysis = ClassAnalysis::with([
            'bar' => $barProperty,
            'baz' => $bazProperty,
        ]);

        $this->assertSame(
            $barProperty,
            $classAnalysis->property('bar')
        );
        $this->assertSame(
            $bazProperty,
            $classAnalysis->property('baz')
        );
    }
}

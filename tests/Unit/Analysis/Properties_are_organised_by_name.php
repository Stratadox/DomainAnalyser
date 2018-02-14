<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit\Analysis;

use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\Analysis\Properties;
use Stratadox\DomainAnalyser\Analysis\Property;

/**
 * @covers \Stratadox\DomainAnalyser\Analysis\Properties
 */
class Properties_are_organised_by_name extends TestCase
{
    /** @test */
    function retrieving_property_analysis_by_name()
    {
        $barProperty = Property::forType('string');
        $bazProperty = Property::forType('int');

        $classAnalysis = Properties::with([
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

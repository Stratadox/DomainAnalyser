<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\PropertyAnalysis;
use Stratadox\DomainAnalyser\Test\Unit\Double\Foo;

/**
 * @covers \Stratadox\DomainAnalyser\PropertyAnalysis
 */
class PropertyAnalysis_contains_information_on_the_property extends TestCase
{
    /**
     * @test
     * @dataProvider scalarTypes
     * @param string $scalarType
     */
    function having_a_property_type_but_no_element_type_for(string $scalarType)
    {
        $this->assertSame(
            $scalarType,
            PropertyAnalysis::forType($scalarType)->type()
        );
        $this->assertNull(
            PropertyAnalysis::forType($scalarType)->elementType()
        );
    }

    public function scalarTypes() : array
    {
        return [
            'string' => ['string'],
            'int' => ['int'],
            'bool' => ['bool'],
            'Foo' => [Foo::class],
            '__CLASS__' => [__CLASS__],
        ];
    }
}

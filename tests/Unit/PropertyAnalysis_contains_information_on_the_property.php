<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\PropertyAnalysis;
use Stratadox\DomainAnalyser\Test\Feature\Double\FooBar\Foo;

/**
 * @covers \Stratadox\DomainAnalyser\PropertyAnalysis
 */
class PropertyAnalysis_contains_information_on_the_property extends TestCase
{
    /**
     * @test
     * @dataProvider scalarTypes
     * @param string           $scalarType
     * @param PropertyAnalysis $property
     */
    function having_a_property_type_but_no_element_type_for(
        string $scalarType,
        PropertyAnalysis $property
    )
    {
        $this->assertSame($scalarType, $property->type());
        $this->assertNull($property->elementType());
    }

    public function scalarTypes() : array
    {
        return [
            'string' => ['string', PropertyAnalysis::forType('string')],
            'int' => ['int', PropertyAnalysis::forType('int')],
            'bool' => ['bool', PropertyAnalysis::forType('bool')],
            'Foo' => [Foo::class, PropertyAnalysis::forType(Foo::class)],
        ];
    }
}

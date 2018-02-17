<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit\Analysis;

use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\Analysis\Property;
use Stratadox\DomainAnalyser\Test\Unit\Double\Foo;
use Stratadox\DomainAnalyser\Test\Unit\Double\Foos;

/**
 * @covers \Stratadox\DomainAnalyser\Analysis\Property
 */
class Property_contains_Type_information extends TestCase
{
    /**
     * @test
     * @dataProvider scalarTypes
     * @param string $scalarType
     */
    function having_a_property_type_but_no_element_type_for($scalarType)
    {
        $this->assertEquals(
            $scalarType,
            Property::forType($scalarType)->type()
        );
        $this->assertNull(
            Property::forType($scalarType)->elementType()
        );
    }

    /**
     * @test
     * @dataProvider collectionTypes
     * @param string $collection
     * @param string $element
     */
    function having_a_property_type_and_element_type_for($collection, $element)
    {
        $this->assertEquals(
            $collection,
            Property::forCollection($collection, $element)->type()
        );
        $this->assertEquals(
            $element,
            Property::forCollection($collection, $element)->elementType()
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

    public function collectionTypes() : array
    {
        return [
            'string[]' => ['array', 'string'],
            'int[]' => ['array', 'int'],
            'bool[]' => ['array', 'bool'],
            'Foo[]' => ['array', Foo::class],
            'Foos' => [Foos::class, Foo::class],
        ];
    }
}

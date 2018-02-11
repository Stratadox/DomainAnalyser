<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\PropertyAnalysis;
use Stratadox\DomainAnalyser\Test\Unit\Double\Foo;
use Stratadox\DomainAnalyser\Test\Unit\Double\Foos;

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
    function having_a_property_type_but_no_element_type_for($scalarType)
    {
        $this->assertSame(
            $scalarType,
            PropertyAnalysis::forType($scalarType)->type()
        );
        $this->assertNull(
            PropertyAnalysis::forType($scalarType)->elementType()
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
        $this->assertSame(
            $collection,
            PropertyAnalysis::forCollection($collection, $element)->type()
        );
        $this->assertSame(
            $element,
            PropertyAnalysis::forCollection($collection, $element)->elementType()
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

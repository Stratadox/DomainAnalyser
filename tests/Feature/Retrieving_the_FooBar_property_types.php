<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Feature;

use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\Analysis\Properties;
use Stratadox\DomainAnalyser\Analysis\Property;
use Stratadox\DomainAnalyser\DomainAnalyser;
use Stratadox\DomainAnalyser\Test\Feature\Double\FooBar\Bar;
use Stratadox\DomainAnalyser\Test\Feature\Double\FooBar\Baz;
use Stratadox\DomainAnalyser\Test\Feature\Double\FooBar\Foo;
use Stratadox\DomainAnalyser\Test\Feature\Double\FooBar\Qux;

/**
 * @coversNothing
 */
class Retrieving_the_FooBar_property_types extends TestCase
{
    /** @var \Stratadox\DomainAnalyser\Analysis\Domain */
    private $analysis;

    protected function setUp()
    {
        $this->analysis = DomainAnalyser::forTheModelsIn(
            __DIR__.'/Double/FooBar'
        )->analyse();
    }

    /** @test */
    function Bar_has_a_string_property()
    {
        $property = $this->propertyOf(Bar::class, 'bar');

        $this->assertEquals(
            'string',
            $property->type()
        );
    }

    /** @test */
    function Baz_has_a_Foo_object()
    {
        $property = $this->propertyOf(Baz::class, 'foo');

        $this->assertEquals(
            Foo::class,
            $property->type()
        );
    }

    /** @test */
    function Foo_has_an_array_of_Bar_objects()
    {
        $property = $this->propertyOf(Foo::class, 'bars');

        $this->assertEquals(
            'array',
            $property->type()
        );
        $this->assertEquals(
            Bar::class,
            $property->elementType()
        );
    }

    /** @test */
    function Qux_references_other_Qux_objects()
    {
        $property = $this->propertyOf(Qux::class, 'quxes');

        $this->assertEquals(
            'array',
            $property->type()
        );
        $this->assertEquals(
            Qux::class,
            $property->elementType()
        );
    }

    private function propertyOf(
        string $class,
        string $property
    ) : Property
    {
        return $this->property($this->analysed($class), $property);
    }

    private function property(
        Properties $classAnalysis,
        string $property
    ) : Property
    {
        return $classAnalysis->property($property);
    }

    private function analysed(string $class) : Properties
    {
        return $this->analysis->ofThe($class);
    }
}

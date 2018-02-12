<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Feature;

use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\ClassAnalysis;
use Stratadox\DomainAnalyser\DomainAnalysis;
use Stratadox\DomainAnalyser\DomainAnalyser;
use Stratadox\DomainAnalyser\PropertyAnalysis;
use Stratadox\DomainAnalyser\Test\Feature\Double\FooBar\Bar;
use Stratadox\DomainAnalyser\Test\Feature\Double\FooBar\Baz;
use Stratadox\DomainAnalyser\Test\Feature\Double\FooBar\Foo;
use Stratadox\DomainAnalyser\Test\Feature\Double\FooBar\Qux;

/**
 * @coversNothing
 */
class Retrieving_the_FooBar_property_types extends TestCase
{
    /** @var DomainAnalysis */
    private $analysis;

    protected function setUp()
    {
        $this->analysis = $this->analyse(__DIR__.'/Double/FooBar');
    }

    /** @test */
    function Bar_has_a_string_property()
    {
        $property = $this->propertyOf(Bar::class, 'bar');

        $this->assertSame(
            'string',
            $property->type()
        );
    }

    /** @test */
    function Baz_has_a_Foo_object()
    {
        $property = $this->propertyOf(Baz::class, 'foo');

        $this->assertSame(
            Foo::class,
            $property->type()
        );
    }

    /** @test */
    function Foo_has_an_array_of_Bar_objects()
    {
        $property = $this->propertyOf(Foo::class, 'bars');

        $this->assertSame(
            'array',
            $property->type()
        );
        $this->assertSame(
            Bar::class,
            $property->elementType()
        );
    }

    /** @test */
    function Qux_references_other_Qux_objects()
    {
        $property = $this->propertyOf(Qux::class, 'quxes');

        $this->assertSame(
            'array',
            $property->type()
        );
        $this->assertSame(
            Qux::class,
            $property->elementType()
        );
    }

    private function propertyOf(
        string $class,
        string $property
    ) : PropertyAnalysis
    {
        return $this->property($this->analysed($class), $property);
    }

    private function property(
        ClassAnalysis $classAnalysis,
        string $property
    ) : PropertyAnalysis
    {
        return $classAnalysis->property($property);
    }

    private function analysed(string $class) : ClassAnalysis
    {
        return $this->analysis->ofThe($class);
    }

    private function analyse(string $directory) : DomainAnalysis
    {
        return DomainAnalyser::forTheModelsIn($directory)->analyse();
    }
}

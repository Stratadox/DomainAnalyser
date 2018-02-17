<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit\Analysis;

use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\Analysis\AmbiguousType;
use Stratadox\DomainAnalyser\Analysis\Type;
use Stratadox\DomainAnalyser\Test\Unit\Double\Bar;
use Stratadox\DomainAnalyser\Test\Unit\Double\Foo;

/**
 * @covers \Stratadox\DomainAnalyser\Analysis\AmbiguousType
 */
class AmbiguousType_can_be_one_of_several_Types extends TestCase
{
    /** @test */
    function iterating_through_possible_types()
    {
        $possibleTypes = AmbiguousType::couldBe('string', 'int', 'bool');

        TestCase::assertCount(3, $possibleTypes);

        foreach ($possibleTypes as $type) {
            TestCase::assertInstanceOf(Type::class, $type);
        }
    }

    /** @test */
    function getting_the_type_through_array_syntax()
    {
        $type = AmbiguousType::maybe(Type::is(Foo::class), Type::is(Bar::class));

        TestCase::assertEquals(Type::is(Foo::class), $type[0]);
        TestCase::assertEquals(Type::is(Bar::class), $type[1]);
    }

    /** @test */
    function silently_formatting_to_string()
    {
        $possibleTypes = AmbiguousType::couldBe('int', 'float', 'null');

        TestCase::assertEquals('int|float|null', $possibleTypes);
    }
}

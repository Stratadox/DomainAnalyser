<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit\Analysis;

use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\Analysis\TypeAnalysis;

/**
 * @covers \Stratadox\DomainAnalyser\Analysis\Type
 */
class TypeAnalysis_contains_information_on_the_type extends TestCase
{
    /** @test */
    function retrieving_a_string_type()
    {
        $type = Type::is('string');
        $this->assertEquals('string', $type);
    }

    /** @test */
    function retrieving_a_class_type()
    {
        $type = Type::is(__CLASS__);
        $this->assertEquals(__CLASS__, $type);
    }
}

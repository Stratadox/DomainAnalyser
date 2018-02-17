<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit\Analysis;

use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\Analysis\Type;

/**
 * @covers \Stratadox\DomainAnalyser\Analysis\Type
 */
class Type_contains_information_on_parameter_types extends TestCase
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

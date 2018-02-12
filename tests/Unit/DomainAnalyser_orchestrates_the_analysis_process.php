<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Test\Unit;

use PHPUnit\Framework\TestCase;
use Stratadox\DomainAnalyser\DomainAnalyser;

/**
 * @covers \Stratadox\DomainAnalyser\DomainAnalyser
 */
class DomainAnalyser_orchestrates_the_analysis_process extends TestCase
{
    /** @test */
    function collect_the_code_and_call_the_parser()
    {
        $this->markTestSkipped('@todo make tests for the data retrievers');
    }
}

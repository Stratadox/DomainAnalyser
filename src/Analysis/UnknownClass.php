<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Analysis;

use InvalidArgumentException;
use function sprintf as withMessage;
use Stratadox\DomainAnalyser\WhenTheRequestedClassWasNotAnalysed;

class UnknownClass extends InvalidArgumentException implements
    WhenTheRequestedClassWasNotAnalysed
{
    public static function neverAnalysedThe(string $class) : UnknownClass
    {
        return new UnknownClass(withMessage(
            'There is no analysis information available for the class: `%s`',
            $class
        ));
    }
}

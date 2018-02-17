<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Analysis;

use Stratadox\DomainAnalyser\DescribesTheProperties;
use Stratadox\DomainAnalyser\DescribesTheProperty;

final class Properties implements DescribesTheProperties
{
    /** @var Property[] */
    private $properties;

    private function __construct(array $properties)
    {
        foreach ($properties as $property => $analysis) {
            $this->mustBeString($property);
            $this->mustDescribeTheProperty($analysis);
        }
        $this->properties = $properties;
    }

    public static function with(array $properties): Properties
    {
        return new Properties($properties);
    }

    public function property(string $name): DescribesTheProperty
    {
        return $this->properties[$name];
    }

    private function mustBeString(string $key): void {}
    private function mustDescribeTheProperty(DescribesTheProperty $value): void {}
}

<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser;

final class ClassAnalysis
{
    /** @var PropertyAnalysis[] */
    private $properties;

    private function __construct(array $properties)
    {
        foreach ($properties as $property => $analysis) {
            $this->mustBeString($property);
            $this->mustBePropertyAnalysis($analysis);
        }
        $this->properties = $properties;
    }

    public static function with(array $properties) : self
    {
        return new self($properties);
    }

    public function property(string $name) : PropertyAnalysis
    {
        return $this->properties[$name];
    }

    private function mustBeString(string $key) : void {}
    private function mustBePropertyAnalysis(PropertyAnalysis $value) : void {}
}
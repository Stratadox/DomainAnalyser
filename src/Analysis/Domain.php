<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Analysis;

final class Domain
{
    private $classes;

    private function __construct(array $classes)
    {
        foreach ($classes as $class => $analysis) {
            $this->mustBeString($class);
            $this->mustBeClassAnalysis($analysis);
        }
        $this->classes = $classes;
    }

    public static function with(array $classes): self
    {
        return new self($classes);
    }

    public function ofThe(string $class): Properties
    {
        return $this->classes[$class];
    }

    private function mustBeString(string $key): void {}
    private function mustBeClassAnalysis(Properties $value): void {}
}

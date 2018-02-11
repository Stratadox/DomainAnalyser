<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser;

final class PropertyAnalysis
{
    private $type;

    private function __construct(string $type)
    {
        $this->type = $type;
    }

    public static function forType(string $type) : self
    {
        return new self($type);
    }

    public function type() : string
    {
        return $this->type;
    }

    public function elementType() : ?string
    {
        return null;
    }
}

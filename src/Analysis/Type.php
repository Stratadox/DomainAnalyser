<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Analysis;

use Stratadox\DomainAnalyser\DescribesTheType;

final class Type implements DescribesTheType
{
    private $type;

    private function __construct(string $type)
    {
        $this->type = $type;
    }

    public static function is(string $type): self
    {
        return new self($type);
    }

    public function __toString(): string
    {
        return $this->type;
    }
}

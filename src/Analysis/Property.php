<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Analysis;

final class Property
{
    private $type;
    private $elementType;

    private function __construct(string $type, ?string $element)
    {
        $this->type = $type;
        $this->elementType = $element;
    }

    public static function forType(string $type): self
    {
        return new self($type, null);
    }

    public static function forCollection(string $type, string $element): self
    {
        return new self($type, $element);
    }

    public function type(): string
    {
        return $this->type;
    }

    public function elementType(): ?string
    {
        return $this->elementType;
    }
}

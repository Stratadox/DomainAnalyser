<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Analysis;

use Stratadox\DomainAnalyser\DescribesTheProperty;
use Stratadox\DomainAnalyser\DescribesTheType;

final class Property implements DescribesTheProperty
{
    private $type;
    private $elementType;

    private function __construct(DescribesTheType $type, ?DescribesTheType $element)
    {
        $this->type = $type;
        $this->elementType = $element;
    }

    public static function forType(string $type): Property
    {
        return new Property(Type::is($type), null);
    }

    public static function forThe(DescribesTheType $type): Property
    {
        return new Property($type, null);
    }

    public static function forCollection(
        string $collection,
        string $element
    ): Property {
        return new Property(Type::is($collection), Type::is($element));
    }

    public static function forTheCollectionOf(
        DescribesTheType $collection,
        DescribesTheType $element
    ): Property {
        return new Property($collection, $element);
    }

    public function type(): DescribesTheType
    {
        return $this->type;
    }

    public function elementType(): ?DescribesTheType
    {
        return $this->elementType;
    }
}

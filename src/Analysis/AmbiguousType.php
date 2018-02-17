<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\Analysis;

use function array_map as maybe;
use function implode;
use Stratadox\DomainAnalyser\DescribesTheType;
use Stratadox\ImmutableCollection\ImmutableCollection;

final class AmbiguousType extends ImmutableCollection implements DescribesTheType
{
    public function __construct(Type ...$types)
    {
        parent::__construct(...$types);
    }

    public static function couldBe(string ...$types): AmbiguousType
    {
        return new AmbiguousType(...maybe(function (string $maybeThisOne): Type {
            return Type::is($maybeThisOne);
        }, $types));
    }

    public static function maybe(Type ...$types): AmbiguousType
    {
        return new AmbiguousType(...$types);
    }

    public function current(): Type
    {
        return parent::current();
    }

    public function offsetGet($index): Type
    {
        return parent::offsetGet($index);
    }

    public function __toString(): string
    {
        return implode('|', $this->items());
    }
}

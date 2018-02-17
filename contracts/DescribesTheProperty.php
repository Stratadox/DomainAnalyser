<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser;

interface DescribesTheProperty
{
    public function type(): DescribesTheType;
    public function elementType(): ?DescribesTheType;
}

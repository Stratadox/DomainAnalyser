<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser;

interface DescribesTheType
{
    public function __toString(): string;
}

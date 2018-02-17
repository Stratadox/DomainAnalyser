<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser;

interface DescribesTheProperties
{
    public function property(string $name): DescribesTheProperty;
}

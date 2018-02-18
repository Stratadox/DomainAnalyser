<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser;

interface DescribesTheDomain
{
    public function ofThe(string $class): DescribesTheProperties;
}

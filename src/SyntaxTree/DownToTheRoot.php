<?php

declare(strict_types=1);

namespace Stratadox\DomainAnalyser\SyntaxTree;

use Iterator;
use PhpParser\Node;

final class DownToTheRoot implements Iterator
{
    private $startingPoint;
    private $currentNode;
    private $distanceTraveled;

    public function __construct(Node $startingPoint)
    {
        $this->startingPoint = $startingPoint;
        $this->currentNode = $startingPoint;
        $this->distanceTraveled = 0;
    }

    public static function startingAt(Node $startingPoint): self
    {
        return new self($startingPoint);
    }

    public function current(): Node
    {
        return $this->currentNode;
    }

    public function next(): void
    {
        $candidate = $this->currentNode->getAttribute('prev');
        if (is_null($candidate)) {
            $candidate = $this->currentNode->getAttribute('parent');
        }
        $this->currentNode = $candidate;
        $this->distanceTraveled++;
    }

    public function key(): int
    {
        return $this->distanceTraveled;
    }

    public function valid(): bool
    {
        return $this->currentNode instanceof Node;
    }

    public function rewind(): void
    {
        $this->currentNode = $this->startingPoint;
        $this->distanceTraveled = 0;
    }
}

<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

class PossibilitiesCollection implements \ArrayAccess, \Iterator
{
    private array $map;
    private int $score = 1;
    private int $pointer = 0;

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->map[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->map[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset === null) {
            $this->map[] = $value;
        } else {
            $this->map[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->map[$offset]);
    }

    public function current(): mixed
    {
        return $this->offsetGet($this->pointer);
    }

    public function next(): void
    {
        $this->pointer++;
    }

    public function key(): mixed
    {
        return $this->pointer;
    }

    public function valid(): bool
    {
        return $this->offsetExists($this->pointer);
    }

    public function rewind(): void
    {
        $this->pointer = 0;
    }
}

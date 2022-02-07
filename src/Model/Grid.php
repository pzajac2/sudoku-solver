<?php

declare(strict_types=1);

namespace SudokuSolver\Model;

use SudokuSolver\Exception\ForbiddenMoveException;
use Webmozart\Assert\Assert;

class Grid implements GridInterface
{
    private string $startingGrid;

    private string $grid;

    public function __construct(Puzzle $puzzle)
    {
        $this->startingGrid = $puzzle->get();
        $this->grid = $this->startingGrid;
    }

    public function getValue(int $x, int $y): int
    {
        return (int)$this->grid[$y * 9 + $x];
    }

    public function setValue(int $x, int $y, int $value)
    {
        try {
            Assert::greaterThanEq($value, 0);
            Assert::lessThanEq($value, 9);
        } catch (\InvalidArgumentException $exception) {
            throw new ForbiddenMoveException('Invalid input value', $exception->getCode(), $exception);
        }
        $index = $y * 9 + $x;
        if ($this->startingGrid[$index]) {
            throw new ForbiddenMoveException('Cannot change fixed cell');
        }
        $this->grid[$index] = $value;
    }
}

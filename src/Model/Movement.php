<?php

declare(strict_types=1);

namespace SudokuSolver\Model;

class Movement implements MovementInterface
{
    private int $x;
    private int $y;
    private int $value;

    public function __construct(int $x, int $y, int $value)
    {
        $this->x = $x;
        $this->y = $y;
        $this->value = $value;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}

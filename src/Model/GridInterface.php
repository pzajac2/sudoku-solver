<?php

declare(strict_types=1);

namespace SudokuSolver\Model;

interface GridInterface
{
    public function getValue(int $x, int $y);

    public function setValue(int $x, int $y, int $value);
}

<?php

declare(strict_types=1);

namespace SudokuSolver\Model;

use Webmozart\Assert\Assert;

class Group extends CellCollection implements CollectionOf9Cells
{
    const SIZE = 3;

    public function getCell(int $x, int $y): Cell
    {
        Assert::range($x, 0, 2, 'X coordinate must be between 0..2');
        Assert::range($y, 0, 2, 'Y coordinate must be between 0..2');

        $id = $y * self::SIZE + $x;
        return $this->cells[$id];
    }
}

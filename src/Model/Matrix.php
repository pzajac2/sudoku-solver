<?php

declare(strict_types=1);

namespace SudokuSolver\Model;

use Webmozart\Assert\Assert;

class Matrix extends CellCollection
{
    private const SIZE = 9;

    protected const TOTAL_ELEMENTS = 81;

    public function getCell(int $x, int $y): Cell
    {
        Assert::range($x, 0, 8, 'X coordinate must be between 0..8');
        Assert::range($y, 0, 8, 'Y coordinate must be between 0..8');

        $id = $y * self::SIZE + $x;
        return $this->cells[$id];
    }

    public function __toString(): string
    {
        $output = '';
        for ($i = 0; $i < self::TOTAL_ELEMENTS; ++$i) {
            $output .= ($i && $i % self::SIZE == 0 ? "\n" : '') . $this->cells[$i];
        }
        return $output;
    }
}

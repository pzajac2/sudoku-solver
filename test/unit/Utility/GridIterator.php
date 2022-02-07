<?php

declare(strict_types=1);

namespace SudokuSolver\UnitTest\Utility;

use SudokuSolver\Model\GridInterface;

class GridIterator
{
    public static function cells(GridInterface $grid): \Generator
    {
        for ($y = 0; $y < 9; ++$y) {
            for ($x = 0; $x < 9; ++$x) {
                yield [$x, $y] => $grid->getValue($x, $y);
            }
        }
    }

    public static function rows(GridInterface $grid): \Generator
    {
        for ($y = 0; $y < 9; ++$y) {
            $values = [];
            for ($x = 0; $x < 9; ++$x) {
                $values[$x] = $grid->getValue($x, $y);
            }
            yield [$y] => $values;
        }
    }

    public static function columns(GridInterface $grid): \Generator
    {
        for ($x = 0; $x < 9; ++$x) {
            $values = [];
            for ($y = 0; $y < 9; ++$y) {
                $values[$y] = $grid->getValue($x, $y);
            }
            yield [$x] => $values;
        }
    }

    public static function groups(GridInterface $grid): \Generator
    {
        for ($i = 0; $i < 9; ++$i) {
            yield $i => static::cellsInGroup($grid, $i);
        }
    }

    public static function cellsInGroup(GridInterface $grid, int $id): \Generator
    {
        $offsets = [
            [0, 0],
            [3, 0],
            [6, 0],
            [0, 3],
            [3, 3],
            [6, 3],
            [0, 6],
            [3, 6],
            [6, 6],
        ];
        [$offsetX, $offsetY] = $offsets[$id];

        for ($y = 0; $y < 3; ++$y) {
            for ($x = 0; $x < 3; ++$x) {
                yield [$offsetX + $x, $offsetY + $y] => $grid->getValue($offsetX + $x, $offsetY + $y);
            }
        }
    }
}

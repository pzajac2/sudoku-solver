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
        // @todo
        yield [];
    }
}

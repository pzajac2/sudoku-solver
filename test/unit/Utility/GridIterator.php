<?php

declare(strict_types=1);

namespace SudokuSolver\UnitTest\Utility;

use SudokuSolver\Model\GridInterface;

class GridIterator
{
    public static function cells(GridInterface $matrix): \Generator
    {
        for ($y=0;$y<9;++$y) {
            for ($x = 0; $x < 9; ++$x) {
                yield [$x, $y] => $matrix->getValue($x, $y);
            }
        }
    }
}

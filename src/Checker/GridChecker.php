<?php

declare(strict_types=1);

namespace SudokuSolver\Checker;

use SudokuSolver\Model\GridInterface;
use SudokuSolver\UnitTest\Utility\GridIterator;

class GridChecker
{
    public static function isFullyFilled(GridInterface $grid): bool
    {
        foreach (GridIterator::cells($grid) as $value) {
            if (!$value) {
                return false;
            }
        }
        return true;
    }

    public static function isSolved(GridInterface $grid): bool
    {
        foreach (GridIterator::cells($grid) as $value) {
            if (!$value) {
                return false;
            }
        }

        foreach (GridIterator::rows($grid) as $values) {
            $uniqueValues = count(array_unique($values));
            if ($uniqueValues != 9) {
                return false;
            }
        }
        foreach (GridIterator::columns($grid) as $values) {
            if ($uniqueValues != 9) {
                return false;
            }
        }

        return true;
    }
}

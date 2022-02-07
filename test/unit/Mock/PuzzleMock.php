<?php

declare(strict_types=1);

namespace SudokuSolver\UnitTest\Mock;

use SudokuSolver\Model\Puzzle;

class PuzzleMock
{
    public static function getEmptyPuzzle(): Puzzle
    {
        return new Puzzle(str_repeat('0', 81));
    }

    public static function getPuzzleCase01()
    {

    }
}

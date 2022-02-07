<?php

declare(strict_types=1);

namespace SudokuSolver\UnitTest\Mock;

use SudokuSolver\Model\Puzzle;

class PuzzleMock
{
    public static function getEmptyPuzzle(): Puzzle
    {
        return new Puzzle(str_repeat('_', 81));
    }

    public static function getPuzzleCase01(): Puzzle
    {
        return new Puzzle('__3_2_6__9__3_5__1__18_64____81_29__7_______8__67_82____26_95__8__2_3__9__5_1_3__');
    }
}

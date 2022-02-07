<?php

declare(strict_types=1);

namespace SudokuSolver\UnitTest\Model;

use SudokuSolver\Model\Grid;
use SudokuSolver\Model\GridInterface;
use SudokuSolver\Model\Puzzle;

class GridTest extends AbstractMatrixInterfaceTest
{
    public function createGrid(Puzzle $puzzle): GridInterface
    {
        return new Grid($puzzle);
    }
}

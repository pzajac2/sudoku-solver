<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

use SudokuSolver\Model\GridInterface;
use SudokuSolver\Model\Movement;

interface SolvingStrategyInterface
{
    public function getNextMove(GridInterface $grid): ?Movement;
}

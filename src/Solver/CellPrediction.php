<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

interface CellPrediction
{
    public function hasAnswer(): bool;
    public function getAnswer(): int;
}

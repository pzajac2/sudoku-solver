<?php

declare(strict_types=1);

namespace SudokuSolver\DomainModelSolver;

interface CellPredictionInterface
{
    public function hasAnswer(): bool;
    public function getAnswer(): int;
    public function getPossibleValues(): array;
}

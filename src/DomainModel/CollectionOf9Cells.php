<?php

declare(strict_types=1);

namespace SudokuSolver\DomainModel;

interface CollectionOf9Cells
{
    public function getCellByIndex(int $index): Cell;
}

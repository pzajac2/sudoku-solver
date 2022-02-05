<?php

declare(strict_types=1);

namespace SudokuSolver\Model;

interface CollectionOf9Cells
{
    public function getCellByIndex(int $index): Cell;
}

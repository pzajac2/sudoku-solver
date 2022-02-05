<?php

declare(strict_types=1);

namespace SudokuSolver\Test\Model;

use SudokuSolver\Model\Row;

class RowTest extends CellCollectionTest
{
    protected function getTestSubject(): string
    {
        return Row::class;
    }
}

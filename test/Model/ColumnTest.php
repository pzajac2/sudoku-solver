<?php

declare(strict_types=1);

namespace SudokuSolver\Test\Model;

use SudokuSolver\Model\Column;

class ColumnTest extends CellCollectionTest
{
    protected function getTestSubject(): string
    {
        return Column::class;
    }
}

<?php

declare(strict_types=1);

namespace SudokuSolver\UnitTest\DomainModel;

use SudokuSolver\DomainModel\Column;

class ColumnTest extends CellCollectionTest
{
    protected function getTestSubject(): string
    {
        return Column::class;
    }
}

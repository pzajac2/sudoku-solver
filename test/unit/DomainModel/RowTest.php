<?php

declare(strict_types=1);

namespace SudokuSolver\UnitTest\DomainModel;

use SudokuSolver\DomainModel\Row;

class RowTest extends CellCollectionTest
{
    protected function getTestSubject(): string
    {
        return Row::class;
    }
}

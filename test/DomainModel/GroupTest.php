<?php

declare(strict_types=1);

namespace SudokuSolver\Test\DomainModel;

use SudokuSolver\DomainModel\Group;

class GroupTest extends CellCollectionTest
{
    protected function getTestSubject(): string
    {
        return Group::class;
    }
}

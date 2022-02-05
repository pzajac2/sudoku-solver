<?php

declare(strict_types=1);

namespace SudokuSolver\Test\Model;

use SudokuSolver\Model\Group;

class GroupTest extends CellCollectionTest
{
    protected function getTestSubject(): string
    {
        return Group::class;
    }
}

<?php

declare(strict_types=1);

namespace SudokuSolver\UnitTest\Model;

use PHPUnit\Framework\TestCase;
use SudokuSolver\Model\GridInterface;
use SudokuSolver\Model\Puzzle;
use SudokuSolver\UnitTest\Mock\PuzzleMock;
use SudokuSolver\UnitTest\Utility\GridIterator;

abstract class AbstractMatrixInterfaceTest extends TestCase
{
    abstract public function createGrid(Puzzle $puzzle): GridInterface;

    public function testCreateEmptyGrid()
    {
        $matrix = $this->createGrid(PuzzleMock::getEmptyPuzzle());

        foreach (GridIterator::cells($matrix) as $key => $value) {
            $this->assertEquals(0, $value);
        }
    }
}

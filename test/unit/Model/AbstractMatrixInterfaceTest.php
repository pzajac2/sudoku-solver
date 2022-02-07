<?php

declare(strict_types=1);

namespace SudokuSolver\UnitTest\Model;

use PHPUnit\Framework\TestCase;
use SudokuSolver\Exception\ForbiddenMoveException;
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

        foreach (GridIterator::cells($matrix) as $value) {
            $this->assertEquals(0, $value);
        }
    }

    public function testEmptyCellsAreWriteble()
    {
        $matrix = $this->createGrid(PuzzleMock::getEmptyPuzzle());

        foreach (GridIterator::cells($matrix) as $key => $value) {
            [$x, $y] = $key;
            $matrix->setValue($x, $y, $x);
            $this->assertEquals($x, $matrix->getValue($x, $y));
        }
    }

    public function testCannotWriteToStartingCells()
    {
        $matrix = $this->createGrid(PuzzleMock::getPuzzleCase01());

        $matrix->setValue(0, 0, 7);
        $matrix->setValue(1, 0, 7);
        $matrix->setValue(3, 0, 7);
        $matrix->setValue(1, 1, 7);

        $this->expectException(ForbiddenMoveException::class);
        $this->expectExceptionMessage('Cannot change fixed cell');
        $matrix->setValue(0, 1, 7);
    }

    /**
     * @param int $value
     * @return void
     * @dataProvider getInvalidCellValues
     */
    public function testWriteInvalidValue(int $value)
    {
        $matrix = $this->createGrid(PuzzleMock::getEmptyPuzzle());

        $this->expectException(ForbiddenMoveException::class);
        $this->expectExceptionMessage('Invalid input value');
        $matrix->setValue(0, 0, $value);
    }

    public function getInvalidCellValues()
    {
        return [
            [-1],
            [-2],
            [10]
        ];
    }
}

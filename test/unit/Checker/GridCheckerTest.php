<?php

declare(strict_types=1);

namespace SudokuSolver\UnitTest\Checker;

use PHPUnit\Framework\TestCase;
use SudokuSolver\Checker\GridChecker;
use SudokuSolver\Model\Grid;
use SudokuSolver\UnitTest\Mock\PuzzleMock;

class GridCheckerTest extends TestCase
{
    public function testGridIsFullyFilled()
    {
        $this->assertFalse(
            GridChecker::isFullyFilled(new Grid(PuzzleMock::getEmptyPuzzle()))
        );
        $this->assertFalse(
            GridChecker::isFullyFilled(new Grid(PuzzleMock::getPuzzleCase01()))
        );
        $this->assertTrue(
            GridChecker::isFullyFilled(new Grid(PuzzleMock::getInvalidSolvedPuzzle()))
        );
        $this->assertTrue(
            GridChecker::isFullyFilled(new Grid(PuzzleMock::getValidSolvedPuzzle()))
        );
    }

    public function testGridIsSolved()
    {
        $this->assertFalse(
            GridChecker::isSolved(new Grid(PuzzleMock::getEmptyPuzzle()))
        );
        $this->assertFalse(
            GridChecker::isSolved(new Grid(PuzzleMock::getPuzzleCase01()))
        );
        $this->assertFalse(
            GridChecker::isSolved(new Grid(PuzzleMock::getInvalidSolvedPuzzle()))
        );
        $this->assertTrue(
            GridChecker::isSolved(new Grid(PuzzleMock::getValidSolvedPuzzle()))
        );
    }

}

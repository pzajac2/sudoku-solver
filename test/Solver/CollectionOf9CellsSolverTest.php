<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

use PHPUnit\Framework\TestCase;
use SudokuSolver\Model\Cell;
use SudokuSolver\Model\Row;

class CollectionOf9CellsSolverTest extends TestCase
{
    public function testSolveWithOneMissingNumber()
    {
        $cells = [
            new Cell(1),
            new Cell(2),
            new Cell(3),
            new Cell(4),
            new Cell(5),
            new Cell(6),
            new Cell(7),
            new Cell(8),
            new Cell(),
        ];
        $row = new Row($cells);
        $solver = new CollectionOf9CellsSolver();
        $result = $solver->solve($row);

        foreach ($result as $prediction) {
            self::assertTrue($prediction->hasAnswer());
        }
        self::assertEquals(9, $result[8]->getAnswer());
    }

    public function testSolveWithTwoMissingNumbers()
    {
        // 4 & 7 are missing
        $cells = [
            new Cell(9),
            new Cell(2),
            new Cell(5),
            new Cell(3),
            new Cell(),
            new Cell(6),
            new Cell(8),
            new Cell(),
            new Cell(1),
        ];
        $row = new Row($cells);
        $solver = new CollectionOf9CellsSolver();
        $result = $solver->solve($row);

        self::assertTrue($result[0]->hasAnswer());
        self::assertTrue($result[1]->hasAnswer());
        self::assertTrue($result[2]->hasAnswer());

        self::assertFalse($result[4]->hasAnswer());
        self::assertFalse($result[7]->hasAnswer());

        self::assertInstanceOf(PossibleCellValues::class, $result[4]);
        self::assertInstanceOf(PossibleCellValues::class, $result[7]);

        self::assertEquals([4, 7], $result[4]->getPossibleValues());
        self::assertEquals([4, 7], $result[7]->getPossibleValues());
    }
}

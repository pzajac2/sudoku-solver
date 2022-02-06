<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

use PHPUnit\Framework\TestCase;
use SudokuSolver\Model\Cell;
use SudokuSolver\Model\Column;
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
        $cellPredictionsFactory = new CellPredictionsFactory();
        $solver = new CollectionOf9CellsSolver($cellPredictionsFactory);
        $solver->solve($row);

        self::assertTrue($cellPredictionsFactory->get($row->getCellByIndex(0))->hasAnswer());
        self::assertTrue($cellPredictionsFactory->get($row->getCellByIndex(1))->hasAnswer());
        self::assertTrue($cellPredictionsFactory->get($row->getCellByIndex(2))->hasAnswer());

        self::assertFalse($cellPredictionsFactory->get($row->getCellByIndex(4))->hasAnswer());
        self::assertFalse($cellPredictionsFactory->get($row->getCellByIndex(7))->hasAnswer());

        self::assertEquals([4, 7], $cellPredictionsFactory->get($row->getCellByIndex(4))->getPossibleValues());
        self::assertEquals([4, 7], $cellPredictionsFactory->get($row->getCellByIndex(7))->getPossibleValues());
    }

    public function testSolveWithCrossingRowAndColumn()
    {
        // 4 & 7 are missing in row
        // 5 & 7 are missing in column
        $crossedCell = new Cell();

        $rowCells = [
            new Cell(9),
            new Cell(2),
            new Cell(5),
            new Cell(3),
            new Cell(),
            new Cell(6),
            new Cell(8),
            $crossedCell,
            new Cell(1),
        ];
        $row = new Row($rowCells);

        $columnCells = [
            new Cell(9),
            new Cell(2),
            new Cell(),
            new Cell(3),
            new Cell(4),
            new Cell(6),
            new Cell(8),
            $crossedCell,
            new Cell(1),
        ];
        $column = new Column($columnCells);

        $cellPredictionsFactory = new CellPredictionsFactory();

        $solver = new CollectionOf9CellsSolver($cellPredictionsFactory);
        $solver->solve($row);
        $solver->solve($column);

        self::assertTrue($cellPredictionsFactory->get($row->getCellByIndex(0))->hasAnswer());
        self::assertTrue($cellPredictionsFactory->get($row->getCellByIndex(1))->hasAnswer());
        self::assertTrue($cellPredictionsFactory->get($row->getCellByIndex(2))->hasAnswer());

        self::assertFalse($cellPredictionsFactory->get($row->getCellByIndex(4))->hasAnswer());
        self::assertTrue($cellPredictionsFactory->get($row->getCellByIndex(7))->hasAnswer());

        // in row
        self::assertEquals([4, 7], $cellPredictionsFactory->get($row->getCellByIndex(4))->getPossibleValues());
        self::assertEquals([7], $cellPredictionsFactory->get($row->getCellByIndex(7))->getPossibleValues());

        // in column
        self::assertEquals([5, 7], $cellPredictionsFactory->get($column->getCellByIndex(2))->getPossibleValues());
        self::assertEquals([7], $cellPredictionsFactory->get($column->getCellByIndex(7))->getPossibleValues());
    }
}

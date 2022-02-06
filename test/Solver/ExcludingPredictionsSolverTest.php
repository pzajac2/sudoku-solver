<?php

declare(strict_types=1);

namespace Solver;

use PHPUnit\Framework\TestCase;
use SudokuSolver\Factory\MatrixFactory;
use SudokuSolver\Solver\CellPredictionsCollection;
use SudokuSolver\Solver\CollectionOf9CellsSolver;
use SudokuSolver\Solver\NeighborCollectionOf9Solver;

class ExcludingPredictionsSolverTest extends TestCase
{

    public function testCase01()
    {
        $puzzle = <<<DATA
24.9813..
.6..7..84
.3.5642.9
...1.54.8
...4.....
4.27.6...
3.1.57.42
72..4..6.
..4.1...3
DATA;
        $matrix = MatrixFactory::createFromString($puzzle);
        $predictionsCollection = new CellPredictionsCollection();


        $collectionOf9Solver = new CollectionOf9CellsSolver($predictionsCollection);

        foreach ($matrix->getRows() as $row) {
            $collectionOf9Solver->solve($row);
        }
        foreach ($matrix->getColumns() as $column) {
            $collectionOf9Solver->solve($column);
        }
        foreach ($matrix->getGroups() as $group) {
            $collectionOf9Solver->solve($group);
        }


        $neighborCollectionSolver = new NeighborCollectionOf9Solver($predictionsCollection);
        foreach ($matrix as $cell) {
            $neighborCollectionSolver->solve($matrix, $cell);
        }
        
        $solver = new \SudokuSolver\Solver\ExcludingPredictionsSolver($predictionsCollection);
        $testedCell = $matrix->getCell(8, 0);

        $solver->solve($matrix, $testedCell);
        $this->assertTrue($predictionsCollection->get($testedCell)->hasAnswer());
        $this->assertEquals(['6'], $predictionsCollection->get($testedCell)->getPossibleValues());
    }
}

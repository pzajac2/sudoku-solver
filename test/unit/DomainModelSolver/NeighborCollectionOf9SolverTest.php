<?php

declare(strict_types=1);

namespace SudokuSolver\UnitTest\DomainModelSolver;

use PHPUnit\Framework\TestCase;
use SudokuSolver\DomainModelSolver\CellPredictionsCollection;
use SudokuSolver\Factory\MatrixFactory;

class NeighborCollectionOf9SolverTest extends TestCase
{
    public function testCase01()
    {
$puzzle = <<<DATA
2...8.3..
.6..7..84
.3.56.2.9
...1.54.8
.........
4.27.6...
3.1..7.4.
72..4..6.
..4.1...3
DATA;
        $matrix = MatrixFactory::createFromString($puzzle);

        $predictionsCollection = new CellPredictionsCollection();
        $solver = new \SudokuSolver\DomainModelSolver\NeighborCollectionOf9Solver($predictionsCollection);
        $testedCell = $matrix->getCell(4, 6);

        $solver->solve($matrix, $testedCell);
        $this->assertEquals([5, 7], $predictionsCollection->get($testedCell)->getPossibleValues());

    }
}

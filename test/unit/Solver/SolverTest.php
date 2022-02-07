<?php

declare(strict_types=1);

namespace SudokuSolver\Test\Solver;

use PHPUnit\Framework\TestCase;
use SudokuSolver\DomainModel\Matrix;
use SudokuSolver\Factory\MatrixFactory;
use SudokuSolver\Solver\Solver;
use SudokuSolver\Utility\MatrixPrinter;
use SudokuSolver\Utility\SudokuReader;

class SolverTest extends TestCase
{
    /**
     * @param string $puzzle
     * @return void
     * @dataProvider getPuzzles
     */
    public function testSolveSudoku(string $puzzle)
    {
        $this->markTestIncomplete('To be removed');
        $matrix = MatrixFactory::createFromString($puzzle);

        echo MatrixPrinter::printFriendly($matrix);

        $solver = new Solver($matrix);

        do {
            if (!$move = $solver->getMove()) {
                $predictions = $solver->getPredictionsForEmptyCells();
                foreach ($predictions as $prediction) {
                    $this->printPrediction($matrix, $prediction);
                }
                break;
            }
            echo str_repeat('~', 60) . "\n\n";

            $this->printPrediction($matrix, $move);

            $solver->apply($move);
            echo MatrixPrinter::printFriendly($matrix);
        } while (!$matrix->isSolved());

        $this->assertTrue($matrix->isSolved());
    }

    public function getPuzzles()
    {
        $this->markTestIncomplete('todo: refactor (filenames will change)');
        $loader = SudokuReader::loadFromFile(__DIR__ . '/../Resource/puzzles-01.sudoku');
        for ($i = 0, $im = count($loader); $i < $im; ++$i) {
            yield [$loader->getPuzzleString($i)];
        }
    }

    private function printPrediction(Matrix $matrix, \SudokuSolver\Solver\CellPredictions $move)
    {
        foreach ($matrix as $id => $matrixCell) {
            if ($matrixCell === $move->getCell()) {
                $x = $id % 9 + 1;
                $y = (int)floor($id / 9) + 1;
                echo "(i) Possible values for Cell at $x, $y are:\n";
                echo implode(", ", $move->getPossibleValues()) . "\n";
                break;
            }
        }
    }
}

<?php

declare(strict_types=1);

namespace SudokuSolver\Test\Solver;

use PHPUnit\Framework\TestCase;
use SudokuSolver\Factory\MatrixFactory;
use SudokuSolver\Model\Matrix;
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
//        $this->markTestIncomplete('Not all puzzles can be solved by now');
        $matrix = MatrixFactory::createFromString($puzzle);

        echo MatrixPrinter::printFriendly($matrix);

        $solver = new Solver($matrix);
        $step = 0;
        do {
            ++$step;
            echo "\n";
            echo "Step #$step\n";
            if (!$move = $solver->getMove()) {
                echo "Unbreakable...\n";
                $predictions = $solver->getPredictionsForEmptyCells();
                foreach ($predictions as $prediction) {
                    $this->printPrediction($matrix, $prediction);
                }
                echo MatrixPrinter::printFriendly($matrix);
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
        $loader = SudokuReader::loadFromFile(__DIR__ . '/../Resource/puzzles-01.sudoku');
        for ($i = 0, $im = count($loader); $i < $im; ++$i) {
            yield [$loader->getPuzzleString($i)];
        }
    }

    private function printPrediction(Matrix $matrix, \SudokuSolver\Solver\CellPredictions $move)
    {
        foreach ($matrix as $id => $matrixCell) {
            if ($matrixCell === $move->getCell()) {
                $x = $id % 9;
                $y = (int)floor($id / 9) ;
                echo "(i) Possible values for Cell at row $y col $x are: ";
                echo implode(", ", $move->getPossibleValues()) . "\n";
                break;
            }
        }
    }
}

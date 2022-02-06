<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

use SudokuSolver\Model\Cell;
use SudokuSolver\Model\Matrix;

/**
 * @todo known bug here
 */
class ExcludingPredictionsSolver
{
    private CellPredictionsCollection $cellPredictionsCollection;

    public function __construct(CellPredictionsCollection $cellPredictionsCollection)
    {
        $this->cellPredictionsCollection = $cellPredictionsCollection;
    }

    public function solve(Matrix $matrix, Cell $cell): void
    {
        $pos = $matrix->getCellPosition($cell);
        $group = $cell->getGroup();

        $thisCellPossibilities = $this->cellPredictionsCollection->get($cell)->getPossibleValues();
        for ($i = 0; $i < 9; ++$i) {
            $testedCell = $group->getCellByIndex($i);
            if ($testedCell->hasValue()) {
                continue;
            }
            if ($testedCell === $cell) {
                continue;
            }
            $possibilities = $this->cellPredictionsCollection->get($testedCell)->getPossibleValues();
            foreach ($possibilities as $v) {
                if (in_array($v, $thisCellPossibilities)) {
                    unset($thisCellPossibilities[array_search($v, $thisCellPossibilities)]);
                }
            }
//            echo "Cell $i could have " . implode(', ', $possibilities) . "\n";
        }
        $this->cellPredictionsCollection->get($cell)->addPossibilities($thisCellPossibilities);
    }
}

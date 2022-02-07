<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

use SudokuSolver\DomainModel\CollectionOf9Cells;

/**
 * Finds possible values for each cell of 9 elements collection
 */
class CollectionOf9CellsSolver
{
    private CellPredictionsCollection $cellPredictionsCollection;

    public function __construct(CellPredictionsCollection $cellPredictionsCollection)
    {
        $this->cellPredictionsCollection = $cellPredictionsCollection;
    }

    public function solve(CollectionOf9Cells $cellCollection): void
    {
        $usedNumbers = [];
        for ($i=0; $i<9; ++$i) {
            $cell = $cellCollection->getCellByIndex($i);
            if ($cell->hasValue()) {
                $usedNumbers[] = $cell->getValue();
            }
        }
        $possibleValues = array_diff(
            [1, 2, 3, 4, 5, 6, 7, 8, 9],
            $usedNumbers
        );

        for ($i=0; $i<9; ++$i) {
            $cell = $cellCollection->getCellByIndex($i);
            $cellPredictions = $this->cellPredictionsCollection->get($cell);

            if ($cell->hasValue()) {
                $cellPredictions->addPossibilities([$cell->getValue()]);
            } else {
                $cellPredictions->addPossibilities($possibleValues);
            }
        }
    }
}

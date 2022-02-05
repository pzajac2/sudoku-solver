<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

use SudokuSolver\Model\CollectionOf9Cells;

/**
 * Finds possible values for each cell of 9 elements collection
 */
class CollectionOf9CellsSolver
{
    /**
     * @return CellPrediction[]
     */
    public function solve(CollectionOf9Cells $cellCollection): array
    {
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

        $result = [];
        for ($i=0; $i<9; ++$i) {
            $cell = $cellCollection->getCellByIndex($i);
            if ($cell->hasValue()) {
                $result[$i] = new CertainCellValue($cell->getValue());
            } else {
                $result[$i] = new PossibleCellValues($possibleValues);
            }
        }
        return $result;
    }
}

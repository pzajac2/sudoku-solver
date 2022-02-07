<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

use SudokuSolver\DomainModel\Cell;
use SudokuSolver\DomainModel\Column;
use SudokuSolver\DomainModel\Matrix;
use SudokuSolver\DomainModel\Row;

class NeighborCollectionOf9Solver
{
    private CellPredictionsCollection $cellPredictionsCollection;

    public function __construct(CellPredictionsCollection $cellPredictionsCollection)
    {
        $this->cellPredictionsCollection = $cellPredictionsCollection;
    }

    public function solve(Matrix $matrix, Cell $cell): void
    {
        $cellPredictions = $this->cellPredictionsCollection->get($cell);

        if ($cell->hasValue()) {
            $cellPredictions->addPossibilities([$cell->getValue()]);
            return;
        }
        $pos = $matrix->getCellPosition($cell);

        $xn = match ($pos[0] % 3) {
            0 => [1, 2],
            1 => [0, 2],
            2 => [0, 1]
        };
        $yn = match ($pos[1] % 3) {
            0 => [1, 2],
            1 => [0, 2],
            2 => [0, 1]
        };
        /** @var Column[] $columns */
        $columns = [
            $matrix->getColumn((int)floor($pos[0] / 3) * 3 + $xn[0]),
            $matrix->getColumn((int)floor($pos[0] / 3) * 3 + $xn[1]),
        ];
        /** @var Row[] $columns */
        $rows = [
            $matrix->getRow((int)floor($pos[1] / 3) * 3 + $yn[0]),
            $matrix->getRow((int)floor($pos[1] / 3) * 3 + $yn[1]),
        ];

        // for column - take two others cells
        $c1 = $matrix->getCell($pos[0], (int)floor($pos[1] / 3) * 3 + $yn[0]);
        $c2 = $matrix->getCell($pos[0], (int)floor($pos[1] / 3) * 3 + $yn[1]);
        $c1v = $c1->getValue();
        $c2v = $c2->getValue();

        $canGuessByColumn = $c1v && $c2v;
        if ($canGuessByColumn) {
            $possibleValuesCols2 = $this->getPossibleValuesFromNeighborCollections($columns);
            $cellPredictions->addPossibilities($possibleValuesCols2);
        }

        // for row - take two others cells
        $c1 = $matrix->getCell((int)floor($pos[0] / 3) * 3 + $xn[0],  $pos[1]);
        $c2 = $matrix->getCell((int)floor($pos[0] / 3) * 3 + $xn[1], $pos[1]);
        $c1v = $c1->getValue();
        $c2v = $c2->getValue();

        $canGuessByRow = $c1v && $c2v;
        if ($canGuessByRow) {
            $possibleValuesRows2 = $this->getPossibleValuesFromNeighborCollections($rows);
            $cellPredictions->addPossibilities($possibleValuesRows2);
        }
    }

    /**
     * @param array $collections
     * @return array
     */
    public function getPossibleValuesFromNeighborCollections(array $collections): array
    {
        $possibleValues = [];
        $numOfHits = [];
        foreach ($collections as $collection) {
            for ($i = 0; $i < 9; ++$i) {
                if (!$collection->getCellByIndex($i)->hasValue()) {
                    continue;
                }
                $v = $collection->getCellByIndex($i)->getValue();
                $numOfHits[$v] = isset($numOfHits[$v]) ? $numOfHits[$v] + 1 : 1;
            }
        }

        foreach ($numOfHits as $value => $occurrences) {
            if ($occurrences == 2) {
                $possibleValues[] = $value;
            }
        }
        return $possibleValues;
    }
}

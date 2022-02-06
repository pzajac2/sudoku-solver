<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

use SudokuSolver\Model\Matrix;

class Solver
{
    private Matrix $matrix;
    private CellPredictionsCollection $cellPredictionsCollection;

    public function __construct(Matrix $matrix)
    {
        $this->matrix = $matrix;
        $this->cellPredictionsCollection = new CellPredictionsCollection();
    }

    private function buildEmptyPredictionsMatrix()
    {
        $this->cellPredictionsCollection->reset();
        for ($i = 0; $i < 81; ++$i) {
            $this->cellPredictionsCollection->get($this->matrix->getCellByIndex($i));
        }
    }

    public function buildPossibleMoves(): array
    {
        $this->cellPredictionsCollection->reset();

        $collectionOf9Solver = new CollectionOf9CellsSolver($this->cellPredictionsCollection);

        foreach ($this->matrix->getRows() as $row) {
            $collectionOf9Solver->solve($row);
        }
        if ($this->cellPredictionsCollection->getPossibleMoves() !== []) {
            return $this->cellPredictionsCollection->getPossibleMoves();
        }

        foreach ($this->matrix->getColumns() as $column) {
            $collectionOf9Solver->solve($column);
        }
        if ($this->cellPredictionsCollection->getPossibleMoves() !== []) {
            return $this->cellPredictionsCollection->getPossibleMoves();
        }

        foreach ($this->matrix->getGroups() as $group) {
            $collectionOf9Solver->solve($group);
        }
        if ($this->cellPredictionsCollection->getPossibleMoves() !== []) {
            return $this->cellPredictionsCollection->getPossibleMoves();
        }

        $excludingPredictionsSolver = new \SudokuSolver\Solver\ExcludingPredictionsSolver($this->cellPredictionsCollection);
        foreach ($this->matrix as $cell) {
            $excludingPredictionsSolver->solve($this->matrix, $cell);
        }
        if ($this->cellPredictionsCollection->getPossibleMoves() !== []) {
            return $this->cellPredictionsCollection->getPossibleMoves();
        }

//        $neighborCollectionSolver = new NeighborCollectionOf9Solver($this->cellPredictionsCollection);
//        foreach ($this->matrix as $cell) {
//            $neighborCollectionSolver->solve($this->matrix, $cell);
//        }

        return $this->cellPredictionsCollection->getPossibleMoves();
    }

    public function getMove(): ?CellPredictions
    {
        // @todo throw dedicated exception
        $list = $this->buildPossibleMoves();
        return isset($list[0]) ? $list[0] : null;
    }

    public function getPredictionsForEmptyCells(): array
    {
        $list = $this->cellPredictionsCollection->getPredictionsForEmptyCells();
        return $list;
    }

    public function apply(CellPredictions $cellPrediction)
    {
        if (!$cellPrediction->hasAnswer()) {
            return;
        }
        $cellPrediction->getCell()->setValue($cellPrediction->getAnswer());
    }
}

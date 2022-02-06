<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

use SudokuSolver\Model\Matrix;

class Solver
{
    private Matrix $matrix;

    public function __construct(Matrix $matrix)
    {
        $this->matrix = $matrix;
        $this->cellPredicitonsFactory = new CellPredictionsFactory();
    }

    private function buildEmptyPredictionsMatrix()
    {
        $this->cellPredicitonsFactory->reset();
        for ($i=0;$i<81;++$i) {
            $this->cellPredicitonsFactory->get($this->matrix->getCellByIndex($i));
        }
    }

    public function getPossibilitiesForMatrix()
    {

    }
}

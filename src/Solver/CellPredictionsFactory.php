<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

use SudokuSolver\Model\Cell;


class CellPredictionsFactory
{
    protected array $instances;

    public function __construct()
    {
        $this->instances = [];
    }

    public function get(Cell $cell): CellPredictions
    {
        $hash = spl_object_hash($cell);
        if (!isset($this->instances[$hash])) {
            $this->instances[$hash] = new CellPredictions($cell);
        }
        return $this->instances[$hash];
    }

    public function reset()
    {
        $this->instances = [];
    }
}

<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

use SudokuSolver\Model\Cell;


class CellPredictionsCollection
{
    /** @var array|CellPredictions[] */
    protected array $instances;

    public function __construct()
    {
        $this->reset();
    }

    public function reset()
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

    /**
     * @return array|CellPredictions[]
     */
    public function getPossibleMoves(): array
    {
        $possibleMoves = [];
        $list = $this->getPredictionsForEmptyCells();
        foreach ($list as $instance) {
            $newAnswer = !$instance->isSolved() && $instance->hasAnswer();
            if ($newAnswer) {
                $possibleMoves[] = $instance;
            }
        }
        return $possibleMoves;
    }

    /**
     * @return array|CellPredictions[]
     */
    public function getPredictionsForEmptyCells()
    {
        return array_filter($this->instances, function (CellPredictions $cell) {
            return (!$cell->getCell()->hasValue());
        });
    }
}

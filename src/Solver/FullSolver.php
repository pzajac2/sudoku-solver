<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

use SudokuSolver\Checker\GridChecker;
use SudokuSolver\Exception\UnbreakablePuzzleException;
use SudokuSolver\Model\Grid;
use SudokuSolver\Model\GridInterface;
use SudokuSolver\Model\Movement;
use SudokuSolver\Model\Puzzle;

class FullSolver
{
    private Puzzle $puzzle;
    private SolvingStrategyInterface $strategy;
    private Grid $grid;

    public function __construct(SolvingStrategyInterface $strategy, Puzzle $puzzle)
    {
        $this->strategy = $strategy;
        $this->puzzle = $puzzle;
        $this->grid = new Grid($puzzle);
    }

    public function getNextMove(): ?Movement
    {
        return $this->strategy->getNextMove($this->grid);
    }

    public function apply(Movement $movement): void
    {
        $this->grid->setValue(
            $movement->getX(),
            $movement->getY(),
            $movement->getValue()
        );
    }

    public function getSolution(): GridInterface
    {
        while ($move = $this->getNextMove()) {
            $this->apply($move);
        }

        if (!GridChecker::isFullyFilled($this->grid)) {
            throw new UnbreakablePuzzleException('Cannot break puzzle - no more moves');
        }

        if (!GridChecker::isSolved($this->grid)) {
            throw new UnbreakablePuzzleException('Cannot break puzzle - invalid values');
        }

        return $this->grid;
    }

    /**
     * @return Grid
     */
    public function getGrid(): Grid
    {
        return $this->grid;
    }
}

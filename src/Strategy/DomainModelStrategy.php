<?php

declare(strict_types=1);

namespace SudokuSolver\Strategy;

use SudokuSolver\DomainModelSolver\Solver;
use SudokuSolver\Factory\MatrixFactory;
use SudokuSolver\Model\GridInterface;
use SudokuSolver\Model\Movement;
use SudokuSolver\Solver\SolvingStrategyInterface;
use SudokuSolver\UnitTest\Utility\GridIterator;

class DomainModelStrategy implements SolvingStrategyInterface
{
    public function getNextMove(GridInterface $grid): ?Movement
    {
        $string = $this->gridToString($grid);
        $matrix = MatrixFactory::createFromString($string);
        $solver = new Solver($matrix);
        if (!$prediction = $solver->getMove()) {
            return null;
        }
        [$x, $y] = $matrix->getCellPosition($prediction->getCell());
        return new Movement($x, $y, $prediction->getAnswer());
    }

    private function gridToString(GridInterface $grid): string
    {
        $output = '';
        foreach (GridIterator::cells($grid) as $value) {
            $output .= $value;
        }
        return $output;
    }

}

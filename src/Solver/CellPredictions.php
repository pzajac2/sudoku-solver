<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

use SudokuSolver\Model\Cell;

/**
 * List possible predictions for each cell
 */
class CellPredictions implements CellPredictionInterface
{
    private Cell $cell;

    /** @var Possibilities[] */
    protected PossibilitiesCollection $possibilities;

    public function __construct(Cell $cell)
    {
        $this->cell = $cell;
        $this->possibilities = new PossibilitiesCollection();
    }

    public function addPossibilities(array $values, int $score = 1)
    {
        $this->possibilities[] = new Possibilities($values, $score);
    }

    public function isSolved(): bool
    {
        return $this->cell->hasValue();
    }

    /**
     * @return array|int[]
     */
    public function getPossibleValues(): array
    {
        if ($this->isSolved()) {
            return [$this->cell->getValue()];
        }

        $allowedValues = [1,2,3,4,5,6,7,8,9];
        foreach ($this->possibilities as $possibility) {
            $possibleValues = $possibility->getValues();
            $newAllowedValues = [];
            foreach ($possibleValues as $value) {
                if (in_array($value, $allowedValues)) {
                    $newAllowedValues[] = $value;
                }
            }
            $allowedValues = $newAllowedValues;
        }
        return $allowedValues;
    }

    public function hasAnswer(): bool
    {
        return count($this->getPossibleValues()) === 1;
    }

    public function getAnswer(): int
    {
        return $this->getPossibleValues()[0];
    }

}

<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

use Webmozart\Assert\Assert;

class PossibleCellValues implements CellPrediction
{
    /** @var array|int[] */
    private array $possibleValues;

    public function __construct(array $possibleValues = [])
    {
        $this->setPossibleValues($possibleValues);
    }

    public function setPossibleValues(array $possibleValues): void
    {
        Assert::allInteger($possibleValues);
        $this->possibleValues = array_values($possibleValues);
    }

    /**
     * @return array|int[]
     */
    public function getPossibleValues(): array
    {
        return $this->possibleValues;
    }

    public function hasAnswer(): bool
    {
        return count($this->possibleValues) === 1;
    }

    public function getAnswer(): int
    {
        if (!$this->hasAnswer()) {
            throw new \LogicException('There\'s no answer for cell');
        }
        return $this->possibleValues[0];
    }
}

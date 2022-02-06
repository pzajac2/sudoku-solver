<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

class Possibilities
{
    private array $values;

    public function __construct(array $values, int $score = 1)
    {
        $this->setValues($values);
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param array $values
     */
    public function setValues(array $values): void
    {
        $this->values = $values;
    }
}

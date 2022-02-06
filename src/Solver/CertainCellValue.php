<?php

declare(strict_types=1);

namespace SudokuSolver\Solver;

use Webmozart\Assert\Assert;

class CertainCellValue implements CellPrediction
{
    private int $certainValue;

    public function __construct(int $sureValue)
    {
        Assert::integer($sureValue);
        $this->certainValue = $sureValue;
    }

    public function hasAnswer(): bool
    {
        return true;
    }

    public function getAnswer(): int
    {
        return $this->certainValue;
    }
}

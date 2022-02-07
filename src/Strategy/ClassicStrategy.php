<?php

declare(strict_types=1);

namespace SudokuSolver\Strategy;

use SudokuSolver\Model\GridInterface;
use SudokuSolver\Model\Movement;
use SudokuSolver\Solver\SolvingStrategyInterface;
use SudokuSolver\UnitTest\Utility\GridIterator;

class ClassicStrategy implements SolvingStrategyInterface
{
    private const ALL = 0b111111111;

    private const SINGLES = [
        0b000000000,
        0b000000001,
        0b000000010,
        0b000000100,
        0b000001000,
        0b000010000,
        0b000100000,
        0b001000000,
        0b010000000,
        0b100000000,
    ];

    public function getNextMove(GridInterface $grid): ?Movement
    {
        $solutionsForRows = [];
        foreach (GridIterator::rows($grid) as $id => $values)
        {
            $solutionsForRows[] = $this->getPossibilities($values);
        }

        $solutionsForCols = [];
        foreach (GridIterator::columns($grid) as $id => $values)
        {
            $solutionsForCols[] = $this->getPossibilities($values);
        }


        // @todo
        $solutionsForGroups = [];
        foreach (GridIterator::groups($grid) as $id => $values)
        {
            $p = [];
            $tmp = [];
            foreach ($values as $pos => $value) {
                $p[] = $pos;
                $tmp[] = $value;
            }
            $solutionsForGroups[] = $this->getPossibilities($tmp);
        }

        $ar = [];
        $br = [];
        $ar = array_map(function(int $v) { return str_pad('0', 9, base_convert((string)$v, 10, 2), STR_PAD_LEFT); }, $solutionsForRows);
        $br = array_map(function(int $v) { return str_pad('0', 9, base_convert((string)$v, 10, 2), STR_PAD_LEFT); }, $solutionsForCols);
        $cr = array_map(function(int $v) { return str_pad('0', 9, base_convert((string)$v, 10, 2), STR_PAD_LEFT); }, $solutionsForCols);

        $r = [];
        for ($y=0; $y<9; ++$y) {
            $r[$y] = [];
            for ($x=0; $x<9; ++$x) {
                $g = (int)floor($y / 3) * 3;
                $g += (int)floor($x / 3);
                $currentValue = $grid->getValue($x, $y);
                if ($currentValue !== 0) {
                    $r[$y][$x] = 0;
                    continue;
                }
                $summedPredictions = $solutionsForRows[$y] & $solutionsForCols[$x]; //  & $solutionsForGroups[$g];
                $summedPredictionsReadable = str_pad('0', 9, base_convert((string)$summedPredictions, 10, 2), STR_PAD_LEFT);
                $r[$y][$x] = $summedPredictions;
            }
        }
        $rr = array_map(function(array $inside) {
            return array_map(function(int $v) { return str_pad('0', 9, base_convert((string)$v, 10, 2), STR_PAD_LEFT); }, $inside);
        }, $r);
        $answer = null;
        foreach ($r as $y => $yvalues) {
            foreach ($yvalues as $x => $value) {
                foreach (self::SINGLES as $key => $testSingle) {
                    if ($value && $value === $testSingle) {
                        $answer = $key;
                        $posY = $y;
                        $posX = $x;
                        break 3;
                    }
                }

            }
        }
        return null;
    }

    private function getPossibilities(array $values): int
    {
        $sum = 0;
        foreach ($values as $value) {
            $sum += $value ? 1 << ($value - 1) : 0;
        }
        return self::ALL - $sum;
    }
}

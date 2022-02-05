<?php

declare(strict_types=1);

namespace SudokuSolver\Utility;

use SudokuSolver\Model\Matrix;

class MatrixPrinter
{
    public static function printFriendly(Matrix $matrix): string
    {
        $output = '';
        for ($y=0;$y<9;++$y) {
            for ($x=0;$x<9;++$x) {
                $value = $matrix->getCell($x, $y)->getValue() ?? ' ';
                $output .= $value;
                if ($x == 2 || $x == 5) {
                    $output .= '|';
                } elseif ($x < 8) {
                    $output .= ' ';
                }

            }
            if ($y == 2 || $y == 5) {
                $output .= "\n";
                $output .= '-----+-----+-----';
            }
            $output .= "\n";
        }

        return $output;
    }
}

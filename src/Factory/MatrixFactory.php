<?php

declare(strict_types=1);

namespace SudokuSolver\Factory;

use SudokuSolver\DomainModel\Cell;
use SudokuSolver\DomainModel\Matrix;

class MatrixFactory
{
    const VALID_CHAR = '/^[0-9\. ]$/';

    public static function createFromString(string $string): Matrix
    {
        $cells = [];
        for ($i=0, $im=strlen($string); $i < $im; ++$i) {
            if (!preg_match(self::VALID_CHAR . '', $string[$i])) {
                continue;
            }
            $isEmpty = in_array($string[$i], [' ', '.', '0']);
            $cells[] = new Cell(!$isEmpty ? (int)$string[$i] : null);
        }
        if (count($cells) !== 81) {
            throw new \InvalidArgumentException('Cannot load puzzle - must have 81 cells');
        }

        return new Matrix($cells);
    }
}

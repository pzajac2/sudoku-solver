<?php

declare(strict_types=1);

namespace SudokuSolver\Test\Utility;

use PHPUnit\Framework\TestCase;
use SudokuSolver\DomainModel\Cell;
use SudokuSolver\DomainModel\Matrix;
use SudokuSolver\Utility\MatrixPrinter;

class MatrixPrinterTest extends TestCase
{
    public function testFriendlyPrint()
    {
        $cells = [];
        for ($i = 0; $i < 81; ++$i) {
            $cells[] = new Cell($i % 9 + 1);
        }
        $cells[1] = new Cell();
        $cells[3] = new Cell();
        $cells[9] = new Cell();
        $cells[77] = new Cell();
        $cells[79] = new Cell();
        $cells[80] = new Cell();
        $matrix = new Matrix($cells);
        $expected = <<<RAW
1 3 56789
 23456789
123456789
123456789
123456789
123456789
123456789
123456789
12345 7  
RAW;
        self::assertSame($expected, (string)$matrix);

        $expectedFriendly = <<<RAW
1   3|  5 6|7 8 9
  2 3|4 5 6|7 8 9
1 2 3|4 5 6|7 8 9
-----+-----+-----
1 2 3|4 5 6|7 8 9
1 2 3|4 5 6|7 8 9
1 2 3|4 5 6|7 8 9
-----+-----+-----
1 2 3|4 5 6|7 8 9
1 2 3|4 5 6|7 8 9
1 2 3|4 5  |7    

RAW;
        $result = MatrixPrinter::printFriendly($matrix);
        self::assertSame($expectedFriendly, $result);
    }
}

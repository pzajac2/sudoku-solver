<?php

declare(strict_types=1);

namespace SudokuSolver\Test\Model;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use SudokuSolver\Model\Cell;
use SudokuSolver\Model\CellType;
use SudokuSolver\Model\Matrix;

class MatrixTest extends TestCase
{
    public function testConstructEmptyMatrix()
    {
        $matrix = new Matrix();

        $cell = $matrix->getCell(0, 0);
        self::assertEquals(false, $cell->hasValue());
        self::assertEquals(CellType::USER, $cell->getType());

        self::assertSame($matrix->getCell(0, 1), $matrix->getCell(0, 1));
        self::assertNotSame($matrix->getCell(0, 1), $matrix->getCell(0, 3));
    }

    public function testConstructMatrixWithInvalidNumberOfCells()
    {
        $cells = [];
        for ($i = 0; $i < 78; ++$i) {
            $cells[] = new Cell(1);
        }
        $this->expectException(InvalidArgumentException::class);
        $matrix = new Matrix($cells);
    }

    public function testConstructMatrixWithInvalidInstanceOfCells()
    {
        $cells = [];
        for ($i = 0; $i < 81; ++$i) {
            $cells[] = new Cell(1);
        }
        $cells[42] = 8;

        $this->expectException(InvalidArgumentException::class);
        $matrix = new Matrix($cells);
    }

    public function testConstructMatrixWithFixedValue()
    {
        $cells = [];
        for ($i = 0; $i < 81; ++$i) {
            $cells[] = new Cell(1);
        }
        $matrix = new Matrix($cells);
        $cell = $matrix->getCell(0, 0);

        for ($i = 0; $i < 81; ++$i) {
            self::assertEquals(true, $cell->hasValue());
            self::assertEquals(1, $cell->getValue());
            self::assertEquals(CellType::FIXED, $cell->getType());
        }
    }

    public function testGetCellByIndex()
    {
        $cells = [];
        for ($i = 0; $i < 81; ++$i) {
            $cells[] = new Cell($i % 9 + 1);
        }
        $matrix = new Matrix($cells);

        for ($i = 0; $i < 81; ++$i) {
            $cell = $matrix->getCellByIndex($i);
            self::assertEquals(true, $cell->hasValue());
            self::assertEquals($i % 9 + 1, $cell->getValue());
            self::assertEquals(CellType::FIXED, $cell->getType());
        }
    }

    public function testMatrixDontHaveDuplicatedObjects()
    {
        $cells = [];
        for ($i = 0; $i < 81; ++$i) {
            $cells[] = new Cell($i % 9 + 1);
        }
        $matrix = new Matrix($cells);

        $hashes = [];
        for ($i = 0; $i < 81; ++$i) {
            $cell = $matrix->getCellByIndex($i);
            $hashes[] = spl_object_hash($cell);
        }
        $uniqueHashes = array_unique($hashes);
        self::assertCount(81, $uniqueHashes);
    }

    public function testMatrixDontAcceptDuplicatedObjects()
    {
        $cells = [];
        for ($i = 0; $i < 81; ++$i) {
            $cells[] = new Cell($i % 9 + 1);
        }
        // same object
        $cells[13] = $cells[11];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Same object instances in input');
        $matrix = new Matrix($cells);
    }

    public function testGetCellByCoordinate()
    {
        $cells = [];
        for ($i = 0; $i < 81; ++$i) {
            $cells[] = new Cell($i % 9 + 1);
        }
        $matrix = new Matrix($cells);

        for ($x = 0; $x < 9; ++$x) {
            for ($y = 0; $y < 9; ++$y) {
                self::assertSame($x+1, $matrix->getCell($x, $y)->getValue());
            }
        }
    }

    public function testToStringCase01()
    {
        $cells = [];
        for ($i = 0; $i < 81; ++$i) {
            $cells[] = new Cell($i % 9 + 1);
        }
        $matrix = new Matrix($cells);
        $expected = <<<RAW
123456789
123456789
123456789
123456789
123456789
123456789
123456789
123456789
123456789
RAW;
        self::assertSame($expected, (string)$matrix);
    }

    public function testToStringCase02()
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
    }
}

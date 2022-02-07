<?php

declare(strict_types=1);

namespace SudokuSolver\Test\DomainModel;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use SudokuSolver\DomainModel\Cell;
use SudokuSolver\DomainModel\CellType;
use SudokuSolver\DomainModel\Column;
use SudokuSolver\DomainModel\Matrix;
use SudokuSolver\DomainModel\Row;

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

    public function testMatrixHasValidRows()
    {
        $cells = [];
        for ($i = 0; $i < 81; ++$i) {
            $cells[] = new Cell($i % 9 + 1);
        }
        $matrix = new Matrix($cells);

        for ($y=0; $y<9; ++$y) {
            $row = $matrix->getRow($y);
            $this->assertInstanceOf(Row::Class, $row);
            for ($x = 0; $x < 9; ++$x) {
                $this->assertEquals($x + 1, $row->getCellByIndex($x)->getValue());
                $this->assertSame($matrix->getCell($x, $y), $row->getCellByIndex($x));
            }
        }
    }

    public function testMatrixHasValidColumns()
    {
        $cells = [];
        for ($i = 0; $i < 81; ++$i) {
            $cells[] = new Cell($i % 9 + 1);
        }
        $matrix = new Matrix($cells);

        for ($x = 0; $x < 9; ++$x) {
            $column = $matrix->getColumn($x);
            $this->assertInstanceOf(Column::Class, $column);
            for ($y=0; $y<9; ++$y) {
                $this->assertEquals($x + 1, $column->getCellByIndex($y)->getValue());
                $this->assertSame($matrix->getCell($x, $y), $column->getCellByIndex($y));
            }
        }
    }

    public function testMatrixHasValidGroups()
    {
        $cells = [];
        for ($i = 0; $i < 81; ++$i) {
            $cells[] = new Cell($i % 9 + 1);
        }
        $matrix = new Matrix($cells);

        $group = $matrix->getGroup(0);

        $this->assertSame($matrix->getCell(0, 0), $group->getCellByIndex(0));
        $this->assertSame($matrix->getCell(1, 0), $group->getCellByIndex(1));
        $this->assertSame($matrix->getCell(2, 0), $group->getCellByIndex(2));
        $this->assertSame($matrix->getCell(0, 1), $group->getCellByIndex(3));
        $this->assertSame($matrix->getCell(1, 1), $group->getCellByIndex(4));
        $this->assertSame($matrix->getCell(2, 1), $group->getCellByIndex(5));
        $this->assertSame($matrix->getCell(0, 2), $group->getCellByIndex(6));
        $this->assertSame($matrix->getCell(1, 2), $group->getCellByIndex(7));
        $this->assertSame($matrix->getCell(2, 2), $group->getCellByIndex(8));

        $this->assertSame($matrix->getCell(0, 0), $group->getCell(0, 0));
        $this->assertSame($matrix->getCell(1, 0), $group->getCell(1, 0));
        $this->assertSame($matrix->getCell(2, 0), $group->getCell(2, 0));
        $this->assertSame($matrix->getCell(0, 1), $group->getCell(0, 1));
        $this->assertSame($matrix->getCell(1, 1), $group->getCell(1, 1));
        $this->assertSame($matrix->getCell(2, 1), $group->getCell(2, 1));
        $this->assertSame($matrix->getCell(0, 2), $group->getCell(0, 2));
        $this->assertSame($matrix->getCell(1, 2), $group->getCell(1, 2));
        $this->assertSame($matrix->getCell(2, 2), $group->getCell(2, 2));
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

<?php

declare(strict_types=1);

namespace SudokuSolver\Test\DomainModel;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use SudokuSolver\DomainModel\Cell;
use SudokuSolver\DomainModel\CellType;

abstract class CellCollectionTest extends TestCase
{
    public function testConstructWithoutArguments()
    {
        $class = $this->getTestSubject();
        $subject = new $class();
        $cell = $subject->getCellByIndex(0);

        for ($i = 0; $i < 9; ++$i) {
            self::assertEquals(false, $cell->hasValue());
            self::assertEquals(null, $cell->getValue());
            self::assertEquals(CellType::USER, $cell->getType());
        }
    }

    public function testConstructWithValidCells()
    {
        $cells = [];
        for ($i = 0; $i < 9; ++$i) {
            $cells[] = new Cell(1);
        }
        $class = $this->getTestSubject();
        $subject = new $class($cells);
        $cell = $subject->getCellByIndex(0);

        for ($i = 0; $i < 9; ++$i) {
            self::assertEquals(true, $cell->hasValue());
            self::assertEquals(1, $cell->getValue());
            self::assertEquals(CellType::FIXED, $cell->getType());
        }
    }

    public function testConstructWithInvalidNumbersOfCells()
    {
        $cells = [];
        for ($i = 0; $i < 5; ++$i) {
            $cells[] = new Cell(1);
        }
        $this->expectException(InvalidArgumentException::class);
        $class = $this->getTestSubject();
        $subject = new $class($cells);
    }

    public function testConstructWithInvalidInstanceOfCell()
    {
        $cells = [];
        for ($i = 0; $i < 9; ++$i) {
            $cells[] = new Cell(1);
        }
        $cells[3] = 8;

        $this->expectException(InvalidArgumentException::class);
        $class = $this->getTestSubject();
        new $class($cells);
    }

    abstract protected function getTestSubject(): string;
}

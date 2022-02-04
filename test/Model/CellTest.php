<?php

declare(strict_types=1);

namespace SudokuSolver\Test\Model;

use PHPUnit\Framework\TestCase;
use SudokuSolver\Model\Cell;
use SudokuSolver\Model\CellType;

class CellTest extends TestCase
{
    public function testConstructEmptyCell()
    {
        $cell = new Cell();
        self::assertInstanceOf(Cell::class, $cell);
        self::assertSame(false, $cell->hasValue());
        self::assertSame(null, $cell->getValue());
        self::assertSame(' ', (string)$cell);
        self::assertSame(CellType::USER, $cell->getType());
    }

    /**
     * @param int|null $value
     * @return void
     * @dataProvider getIntegerCellValues
     */
    public function testConstructCellWithValue(?int $value)
    {
        $cell = new Cell($value);
        self::assertInstanceOf(Cell::class, $cell);
        self::assertSame(true, $cell->hasValue());
        self::assertSame($value, $cell->getValue());
        self::assertSame((string)$value, (string)$cell);
        self::assertEquals(CellType::FIXED, $cell->getType());
    }

    /**
     * @param int|null $value
     * @return void
     * @dataProvider getIntegerCellValues
     * @dataProvider getNullCellValues
     */
    public function testConstructEmptyCellAndWithValue(?int $value)
    {
        $cell = new Cell();
        $cell->setValue($value);
        self::assertInstanceOf(Cell::class, $cell);
        self::assertSame($value !== null, $cell->hasValue());
        self::assertSame($value, $cell->getValue());
        self::assertSame($value !== null ? (string)$value : ' ', (string)$cell);
        self::assertEquals(CellType::USER, $cell->getType());
    }

    /**
     * @dataProvider getInvalidCellValues
     */
    public function testConstructEmptyCellWithInvalidValue(mixed $value)
    {
        $this->expectException(
            is_int($value)
            ? \InvalidArgumentException::class
            : \TypeError::class
        );
        new Cell($value);
    }

    public function getInvalidCellValues(): array
    {
        return [
            [0],
            [-1],
            [10],
            ['a'],
            [3.1],
            [true],
        ];
    }

    public function getIntegerCellValues(): array
    {
        $values = [];
        for ($i = 1; $i <= 9; ++$i) {
            $values[] = [$i];
        }
        return $values;
    }

    public function getNullCellValues(): array
    {
        return [
            [null]
        ];
    }
}

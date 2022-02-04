<?php

declare(strict_types=1);

namespace SudokuSolver\Model;

use Webmozart\Assert\Assert;

class Matrix
{
    private const SIZE = 9;
    private const TOTAL_ELEMENTS = 81;

    private array $cells = [];

    public function __construct(array $cells = [])
    {
        if (count($cells) === 0) {
            for ($i = 0; $i < self::TOTAL_ELEMENTS; ++$i) {
                $this->cells[$i] = new Cell();
            }
            return;
        }

        Assert::count($cells, self::TOTAL_ELEMENTS);

        Assert::allIsInstanceOf($cells, Cell::class, 'Constructor argument must be array of Cell');
        static::validateCellsUniqness($cells);

        $this->cells = $cells;
    }

    private static function validateCellsUniqness(array $cells)
    {
        $hashes = [];
        foreach($cells as $cell) {
            $hashes[] = spl_object_hash($cell);
        }
        if (count(array_unique($hashes)) !== self::TOTAL_ELEMENTS) {
            throw new \InvalidArgumentException('Same object instances in input');
        }
    }

    public function getCell(int $x, int $y): Cell
    {
        Assert::range($x, 0, 8, 'X coordinate must be between 0..8');
        Assert::range($y, 0, 8, 'Y coordinate must be between 0..8');

        $id = $y * self::SIZE + $x;
        return $this->cells[$id];
    }

    public function getCellByIndex(int $index): Cell
    {
        Assert::range($index, 0, self::TOTAL_ELEMENTS - 1, 'Index must be between 0..81');
        return $this->cells[$index];
    }

    public function __toString(): string
    {
        $output = '';
        for ($i = 0; $i < self::TOTAL_ELEMENTS; ++$i) {
            $output .= ($i && $i % self::SIZE == 0 ? "\n" : '') . $this->cells[$i];
        }
        return $output;
    }
}

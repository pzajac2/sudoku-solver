<?php

declare(strict_types=1);

namespace SudokuSolver\Model;

use SudokuSolver\Utility\ObjectUniqueness;
use Webmozart\Assert\Assert;

abstract class CellCollection
{
    protected const TOTAL_ELEMENTS = 9;

    protected array $cells = [];

    public function __construct(array $cells = [])
    {
        if (count($cells) === 0) {
            for ($i = 0; $i < static::TOTAL_ELEMENTS; ++$i) {
                $this->cells[$i] = new Cell();
            }
            return;
        }

        Assert::allIsInstanceOf($cells, Cell::class, 'Constructor argument must be array of Cell');
        Assert::count(
            $cells,
            static::TOTAL_ELEMENTS,
            sprintf('Constructor argument must contain %d elements of Cell objects', self::TOTAL_ELEMENTS)
        );
        ObjectUniqueness::validate($cells);

        $this->cells = $cells;
    }

    public function getCellByIndex(int $index): Cell
    {
        Assert::range($index, 0, static::TOTAL_ELEMENTS - 1, 'Index must be between 0..' . (static::TOTAL_ELEMENTS - 1));
        return $this->cells[$index];
    }
}

<?php

declare(strict_types=1);

namespace SudokuSolver\DomainModel;

use Webmozart\Assert\Assert;

class Matrix extends CellCollection
{
    private const SIZE = 9;

    protected const TOTAL_ELEMENTS = 81;

    private array $rows;

    private array $columns;

    private array $groups;

    public function __construct(array $cells = [])
    {
        parent::__construct($cells);
        $this->prepareRows();
        $this->prepareColumns();
        $this->prepareGroups();
    }

    public function getCell(int $x, int $y): Cell
    {
        Assert::range($x, 0, 8, 'X coordinate must be between 0..8');
        Assert::range($y, 0, 8, 'Y coordinate must be between 0..8');

        $id = $y * self::SIZE + $x;
        return $this->cells[$id];
    }

    public function __toString(): string
    {
        $output = '';
        for ($i = 0; $i < self::TOTAL_ELEMENTS; ++$i) {
            $output .= ($i && $i % self::SIZE == 0 ? "\n" : '') . $this->cells[$i];
        }
        return $output;
    }

    private function prepareRows()
    {
        for ($y = 0; $y < static::SIZE; ++$y) {
            $cells = [];
            for ($x = 0; $x < static::SIZE; ++$x) {
                $cells[] = $this->getCell($x, $y);
            }
            $this->rows[$y] = new Row($cells);

            // back reference
            for ($x = 0; $x < static::SIZE; ++$x) {
                $this->rows[$y]->getCellByIndex($x)->setRow($this->rows[$y]);
            }
        }
    }

    private function prepareColumns()
    {
        for ($x = 0; $x < static::SIZE; ++$x) {
            $cells = [];
            for ($y = 0; $y < static::SIZE; ++$y) {
                $cells[] = $this->getCell($x, $y);
            }
            $this->columns[$x] = new Column($cells);

            // back reference
            for ($y = 0; $y < static::SIZE; ++$y) {
                $this->columns[$x]->getCellByIndex($y)->setColumn($this->columns[$x]);
            }
        }
    }

    private function prepareGroups()
    {
        $groups = [];
        for ($y = 0; $y < static::SIZE; ++$y) {
            for ($x = 0; $x < static::SIZE; ++$x) {
                $groupId = (int)(floor($x / 3) + 3 * floor($y / 3));
                if (!isset($groups[$groupId])) {
                    $groups[$groupId] = [];
                }
                $groups[$groupId][] = $this->getCell($x, $y);
            }
        }
        for ($i = 0; $i < 9; ++$i) {
            $this->groups[$i] = new Group($groups[$i]);

            for ($j = 0; $j < static::SIZE; ++$j) {
                $this->groups[$i]->getCellByIndex($j)->setGroup($this->groups[$i]);
            }
        }
    }

    public function getRow(int $index): Row
    {
        return $this->rows[$index];
    }

    public function getColumn(int $index): Column
    {
        return $this->columns[$index];
    }

    public function getGroup(int $index): Group
    {
        return $this->groups[$index];
    }

    /**
     * @return array
     */
    public function getRows(): array
    {
        return $this->rows;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return array
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * @return array Two integers with Cell position [x, y]
     */
    public function getCellPosition(Cell $cell): array
    {
        foreach ($this as $id => $matrixCell) {
            if ($matrixCell === $cell) {
                $x = $id % 9;
                $y = (int)floor($id / 9);
                return [$x, $y];
            }
        }
        throw new \InvalidArgumentException();
    }

    public function isSolved()
    {
        $allValid = true;
        /** @var Cell $cell */
        foreach ($this as $cell) {
            $allValid = $allValid && $cell->hasValue();
        }
        return $allValid;
    }
}

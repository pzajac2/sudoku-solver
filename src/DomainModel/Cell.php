<?php

declare(strict_types=1);

namespace SudokuSolver\DomainModel;

class Cell
{
    private ?int $value;

    private CellType $type;

    private Row $row;

    private Column $column;

    private Group $group;

    public function __construct(?int $value = null)
    {
        $this->setValue($value);
        $this->type = $value !== null ? CellType::FIXED : CellType::USER;
    }

    public function hasValue(): bool
    {
        return $this->value !== null;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(?int $value): void
    {
        if ($value === 0) {
            $value = null;
        }
        if ($value !== null && !($value >= 1 && $value <= 9)) {
            throw new \InvalidArgumentException('Cell value must be null or between 0..9');
        }
        $this->value = $value;
    }

    public function getType(): CellType
    {
        return $this->type;
    }

    public function __toString(): string
    {
        return $this->value !== null ? (string)$this->value : ' ';
    }

    /**
     * @return Row
     */
    public function getRow(): Row
    {
        return $this->row;
    }

    /**
     * @param Row $row
     */
    public function setRow(Row $row): void
    {
        $this->row = $row;
    }

    /**
     * @return Column
     */
    public function getColumn(): Column
    {
        return $this->column;
    }

    /**
     * @param Column $column
     */
    public function setColumn(Column $column): void
    {
        $this->column = $column;
    }

    /**
     * @return Group
     */
    public function getGroup(): Group
    {
        return $this->group;
    }

    /**
     * @param Group $group
     */
    public function setGroup(Group $group): void
    {
        $this->group = $group;
    }
}

<?php

declare(strict_types=1);

namespace SudokuSolver\Model;

class Cell
{
    private ?int $value;

    private CellType $type;

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
}

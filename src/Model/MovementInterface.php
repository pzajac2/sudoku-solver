<?php

declare(strict_types=1);

namespace SudokuSolver\Model;

interface MovementInterface
{
    public function getX(): int;

    public function getY(): int;

    public function getValue(): int;
}

<?php

declare(strict_types=1);

namespace SudokuSolver\DomainModel;

enum CellType {
    case FIXED;
    case USER;
}

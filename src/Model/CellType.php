<?php

declare(strict_types=1);

namespace SudokuSolver\Model;

enum CellType {
    case FIXED;
    case USER;
}

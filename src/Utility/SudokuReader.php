<?php

declare(strict_types=1);

namespace SudokuSolver\Utility;

use SudokuSolver\Factory\MatrixFactory;
use SudokuSolver\Model\Matrix;

class SudokuReader implements \Countable
{
    const VALID_CHAR = '/^[ \.0-9]$/';
    const VALID_LINE = '/[ \.0-9]{9}/';
    private array $puzzles = [];

    public function __construct()
    {
    }

    public function addPuzzle(string $puzzle): void
    {
        $this->puzzles[] = $puzzle;
    }

    public static function loadFromFile(string $filename): static
    {
        $contents = file_get_contents($filename);
        return static::loadFromString($contents);
    }

    public static function loadFromString($contents): static
    {
        $lines = preg_split("/\r?\n/", $contents);

        $subject = new static();
        $buffer = '';
        foreach ($lines as $line)
        {
            $valid = preg_match(self::VALID_LINE, $line);
            if (!$valid) {
                continue;
            }

            for ($i = 0, $im = strlen($line); $i < $im; ++$i) {
                if (!preg_match(self::VALID_CHAR, $line[$i])) {
                    continue;
                }
                $buffer .= $line[$i];
            }

            if (strlen($buffer) == 81) {
                $subject->addPuzzle($buffer);
                $buffer = '';
            }
        }
        return $subject;
    }

    public function count(): int
    {
        return count($this->puzzles);
    }

    public function getPuzzle(int $id): Matrix
    {
        if (!isset($this->puzzles[$id])) {
            throw new \OutOfBoundsException();
        }
        $buffer = $this->puzzles[$id];
        return MatrixFactory::createFromString($buffer);
    }
}

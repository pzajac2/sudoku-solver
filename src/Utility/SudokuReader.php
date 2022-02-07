<?php

declare(strict_types=1);

namespace SudokuSolver\Utility;

use SudokuSolver\Model\Puzzle;

class SudokuReader implements \Countable
{
    const VALID_CHAR = '/^[ .\-_0-9]$/';
    const VALID_LINE = '/^[ .\-_0-9]{1}/';

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
        if (!file_exists($filename)) {
            throw new \InvalidArgumentException("File $filename doesn't exists");
        }
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
            if (!$valid = preg_match(self::VALID_LINE, $line)) {
                continue;
            }

            for ($i = 0, $im = strlen($line); $i < $im; ++$i) {
                if (!preg_match(self::VALID_CHAR, $line[$i])) {
                    continue;
                }
                $buffer .= is_numeric($line[$i]) ? $line[$i] : '0';

                if (strlen($buffer) == 81) {
                    $subject->addPuzzle($buffer);
                    $buffer = '';
                }
            }

        }
        return $subject;
    }

    public function count(): int
    {
        return count($this->puzzles);
    }

    public function getPuzzle(int $id): Puzzle
    {
        if (!isset($this->puzzles[$id])) {
            throw new \OutOfBoundsException();
        }
        $buffer = $this->puzzles[$id];
        return new Puzzle($buffer);
    }

    public function getPuzzleString(int $id): string
    {
        if (!isset($this->puzzles[$id])) {
            throw new \OutOfBoundsException();
        }
        return $this->puzzles[$id];
    }
}

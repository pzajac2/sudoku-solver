<?php

declare(strict_types=1);

namespace SudokuSolver\Model;

use Webmozart\Assert\Assert;

/**
 * Class represents starting grid for game
 */
class Puzzle
{
    private string $definition;

    public function __construct(string $definition)
    {
        Assert::length($definition, 81);
        Assert::regex($definition, '/^[.\-_ 0-9]{81}/');

        for ($i=0, $im=strlen($definition); $i<$im;++$i) {
            if (in_array($definition[$i], [' ', '-', '.', '_'])) {
                $definition[$i] = '0';
            }
        }

        $this->definition = $definition;
    }

    public function get(): string
    {
        return $this->definition;
    }

    public function __toString(): string
    {
        return $this->definition;
    }
}

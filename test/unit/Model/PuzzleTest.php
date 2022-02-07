<?php

declare(strict_types=1);

namespace SudokuSolver\UnitTest\Model;

use PHPUnit\Framework\TestCase;
use SudokuSolver\Model\Puzzle;

class PuzzleTest extends TestCase
{
    /**
     * @return void
     * @dataProvider getInvalidDefinitions
     */
    public function testConstructWithInvalidArguments(string $input)
    {
        $this->expectException(\InvalidArgumentException::class);
        new Puzzle($input);
    }

    /**
     * @return void
     * @dataProvider getValidDefinitions
     */
    public function testConstructWithValidArguments(string $input, string $expected)
    {
        $puzzle = new Puzzle($input);
        $this->assertSame($expected, $puzzle->get());
        $this->assertSame($expected, (string)$puzzle);
    }

    public function getInvalidDefinitions(): array
    {
        return [
            [''],
            ['a'],
            ['12345-_'],
            ['123456789123456789123456789123456789123456789123456789123456789123456789123456a89']
        ];
    }

    public function getValidDefinitions()
    {
        return [
            [
                '123456789123456789123456789123456789123456789123456789123456789123456789123456789',
                '123456789123456789123456789123456789123456789123456789123456789123456789123456789'
            ],
        ];
    }
}

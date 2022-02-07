<?php

declare(strict_types=1);

namespace SudokuSolver\UnitTest\Utility;

use PHPUnit\Framework\TestCase;
use SudokuSolver\Model\Puzzle;
use SudokuSolver\Utility\SudokuReader;

class SudokuReaderTest extends TestCase
{
    protected const PUZZLE_01 = '003020600900305001001806400008102900700000008006708200002609500800203009005010300';

    protected const PUZZLE_02 = '200080300060070084030500209000105408000000000402706000301007040720040060004010003';

    public function testLoadFromNotExistingFile()
    {
        $this->expectException(\InvalidArgumentException::class);
        $reader = SudokuReader::loadFromFile(__DIR__ . '/not-exisiting.sudoku');
    }

    /**
     * @param $filename
     * @return void
     * @dataProvider getTestFiles
     */
    public function testLoad($filename)
    {
        $reader = SudokuReader::loadFromFile($filename);

        $this->assertEquals(2, count($reader));
        $this->assertEquals(2, $reader->count());

        $this->assertEquals(self::PUZZLE_01, $reader->getPuzzleString(0));
        $this->assertEquals(self::PUZZLE_02, $reader->getPuzzleString(1));

        $this->assertInstanceOf(Puzzle::class, $reader->getPuzzle(0));
        $this->assertInstanceOf(Puzzle::class, $reader->getPuzzle(1));

        $this->assertEquals(self::PUZZLE_01, $reader->getPuzzle(0)->get());
        $this->assertEquals(self::PUZZLE_02, $reader->getPuzzle(1)->get());

    }

    public function getTestFiles()
    {
        return [
            'file-01.sudoku' => [__DIR__ . '/../Resource/file-01.sudoku'],
            'file-02.sudoku' => [__DIR__ . '/../Resource/file-02.sudoku'],
            'file-03.sudoku' => [__DIR__ . '/../Resource/file-03.sudoku'],
            'file-01-one-line.sudoku' => [__DIR__ . '/../Resource/file-01-one-line.sudoku'],
            'file-02-one-line.sudoku' => [__DIR__ . '/../Resource/file-02-one-line.sudoku'],
            'file-03-one-line.sudoku' => [__DIR__ . '/../Resource/file-03-one-line.sudoku'],
            'file-01-splited-line.sudoku' => [__DIR__ . '/../Resource/file-01-splited-line.sudoku'],
            'file-02-splited-line.sudoku' => [__DIR__ . '/../Resource/file-02-splited-line.sudoku'],
            'file-03-splited-line.sudoku' => [__DIR__ . '/../Resource/file-03-splited-line.sudoku'],
        ];
    }
}

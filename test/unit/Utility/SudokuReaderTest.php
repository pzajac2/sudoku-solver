<?php

declare(strict_types=1);

namespace SudokuSolver\UnitTest\Utility;

use PHPUnit\Framework\TestCase;
use SudokuSolver\DomainModel\Matrix;
use SudokuSolver\Utility\SudokuReader;

class SudokuReaderTest extends TestCase
{
    public function testLoad01()
    {
        $filename = __DIR__ . '/../Resource/file-01-one-line.sudoku';
        $reader = SudokuReader::loadFromFile($filename);
        $count = count($reader);
        $this->assertEquals(50, $count);

        $matrix = $reader->getPuzzle(0);
        $this->assertInstanceOf(Matrix::class, $matrix);
        $expected = <<<DATA
  3 2 6  
9  3 5  1
  18 64  
  81 29  
7       8
  67 82  
  26 95  
8  2 3  9
  5 1 3  
DATA;

        $this->assertSame($expected, (string)$matrix);
    }

    public function testLoad02()
    {
        $this->markTestIncomplete('todo: refactor');
        $filename = __DIR__ . '/../Resource/puzzles-02.sudoku';
        $reader = SudokuReader::loadFromFile($filename);
        $count = count($reader);
        $this->assertEquals(95, $count);

        $matrix = $reader->getPuzzle(0);
        $this->assertInstanceOf(Matrix::class, $matrix);
        $expected = <<<DATA
4     8 5
 3       
   7     
 2     6 
    8 4  
    1    
   6 3 7 
5  2     
1 4      
DATA;

        $this->assertSame($expected, (string)$matrix);
    }

    public function getTestFiles()
    {
        return [
            [__DIR__ . '/../Resource/file-01.sudoku'],
            [__DIR__ . '/../Resource/file-02.sudoku'],
            [__DIR__ . '/../Resource/file-03.sudoku'],
            [__DIR__ . '/../Resource/file-01-one-line.sudoku'],
            [__DIR__ . '/../Resource/file-02-one-line.sudoku'],
            [__DIR__ . '/../Resource/file-03-one-line.sudoku'],
            [__DIR__ . '/../Resource/file-01-splited-line.sudoku'],
            [__DIR__ . '/../Resource/file-02-splited-line.sudoku'],
            [__DIR__ . '/../Resource/file-03-splited-line.sudoku'],
        ];
    }
}

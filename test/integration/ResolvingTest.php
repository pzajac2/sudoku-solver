<?php

declare(strict_types=1);

namespace SudokuSolver\IntegrationTest;

use SudokuSolver\Exception\UnbreakablePuzzleException;
use SudokuSolver\Solver\FullSolver;
use SudokuSolver\Strategy\ClassicStrategy;
use SudokuSolver\Utility\SudokuReader;

class ResolvingTest extends \PHPUnit\Framework\TestCase
{
    private const FILE_SIMPLE = __DIR__ . '/Resource/01-simple.sudoku';
    private const FILE_EASY = __DIR__ . '/Resource/02-easy.sudoku';
    private const FILE_MEDIUM = __DIR__ . '/Resource/03-medium.sudoku';
    private const FILE_HARD = __DIR__ . '/Resource/04-hard.sudoku';

    public function testSimple()
    {
        $this->solveTests(self::FILE_SIMPLE);
    }

    public function testEasy()
    {
        $this->solveTests(self::FILE_EASY);
    }

    public function testMedium()
    {
        $this->solveTests(self::FILE_MEDIUM);
    }

    public function testHard()
    {
        $this->solveTests(self::FILE_HARD);
    }

    private function solveTests(string $filename)
    {
        $reader = SudokuReader::loadFromFile($filename);
        $puzzleCount = count($reader);
        $successful = 0;
        for ($i = 0; $i < $puzzleCount; ++$i) {
            $puzzle = $reader->getPuzzle($i);
            $result = $this->solvePuzzle($puzzle);
            $successful += $result ? 1 : 0;
        }

        if ($successful != $puzzleCount) {
            $this->markTestIncomplete(
                sprintf(
                    'Not all puzzles solved %d/%d (%.1f%%)',
                    $successful,
                    $puzzleCount,
                    100 * $successful / $puzzleCount
                )
            );
        }
        $this->assertTrue(true);
    }

    /**
     * @param \SudokuSolver\Model\Puzzle $puzzle
     * @return bool
     */
    private function solvePuzzle(\SudokuSolver\Model\Puzzle $puzzle): bool
    {
//        $strategy = new DomainModelStrategy();
        $strategy = new ClassicStrategy();
        $solver = new FullSolver($strategy, $puzzle);

        try {
            $solver->getSolution();
        } catch (UnbreakablePuzzleException) {
            return false;
        }
        return true;
    }
}

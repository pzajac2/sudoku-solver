<?php

declare(strict_types=1);

namespace SudokuSolver\Utility;

class ObjectUniqueness
{
    /**
     * @param array $collection
     * @return void
     * @throws \InvalidArgumentException
     */
    public static function validate(array $collection): void
    {
        $hashes = [];
        foreach($collection as $cell) {
            $hashes[] = spl_object_hash($cell);
        }
        if (count(array_unique($hashes)) !== count($collection)) {
            throw new \InvalidArgumentException('Same object instances in input');
        }
    }
}

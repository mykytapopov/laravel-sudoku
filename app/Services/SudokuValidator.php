<?php

declare(strict_types=1);

namespace App\Services;

class SudokuValidator
{
    /**
     * @param  array  $board
     *
     * @return bool
     */
    public function isValid(array $board): bool
    {
        foreach ($board as $row) {
            if ($this->hasListDuplications($row)) {
                return false;
            }
        }

        return true;
    }

    private function hasListDuplications(array $list): bool
    {
        $valueCounts = array_count_values($list);
        unset($valueCounts['.']);

        return count(array_flip($valueCounts)) > 1;
    }
}

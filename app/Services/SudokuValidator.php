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
        $board90 = [];
        foreach ($board as $row) {
            if ($this->hasListDuplications($row)) {
                return false;
            }

            foreach ($row as $columnNum => $cell) {
                if (isset($board90[$columnNum][$cell]) && $cell !== "." ) {
                    return false;
                }

                $board90[$columnNum][$cell] = true;
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

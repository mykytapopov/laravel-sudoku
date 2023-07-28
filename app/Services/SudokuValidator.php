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
        // check rows
        foreach ($board as $row) {
            if ($this->hasListDuplications($row)) {
                return false;
            }
        }

        // check columns
        $board90 = [];
        foreach ($board as $row) {
            foreach ($row as $columnNum => $cell) {
                if (isset($board90[$columnNum][$cell]) && $cell !== ".") {
                    return false;
                }
                $board90[$columnNum][$cell] = true;
            }
        }

        // check blocks
        $blocks = $this->getBoardBlocks($board);
        foreach ($blocks as $block) {
            if ($this->hasListDuplications(array_merge(...$block))) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param  array  $board
     *
     * @return array
     */
    private function getBoardBlocks(array $board): array
    {
        foreach ($board as $rowNumber => $row) {
            $board[$rowNumber] = array_chunk($row, 3);
        }
        $chunkedBoard = array_chunk($board, 3);

        $blocks = [];
        foreach ($chunkedBoard as $blockRows) {
            $block = [];
            foreach ($blockRows as $row) {
                foreach ($row as $blockNumber => $blockCells) {
                    $block[$blockNumber][] = $blockCells;
                }
            }
            $blocks = array_merge($blocks, $block);
        }

        return $blocks;
    }

    /**
     * @param  array  $list
     *
     * @return bool
     */
    private function hasListDuplications(array $list): bool
    {
        $valueCounts = array_count_values($list);
        unset($valueCounts['.']);

        foreach ($valueCounts as $value => $count) {
            if ($count > 1) {
                return false;
            }
        }

        return true;
    }
}

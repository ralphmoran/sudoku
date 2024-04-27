<?php

namespace App\Service;

use League\Csv\Reader;

/**
 * Class SudokuValidatorService
 *
 * A service to validate Sudoku puzzles.
 *
 * @package App\Service
 */
class SudokuValidatorService
{
    /**
     * It checks if the number of rows is a perfect square and then iterates 
     * over each row to ensure that each row has the same number of columns as 
     * the total number of rows. If any of these conditions fail, the grid is 
     * considered invalid.
     *
     * @param   string  $path The path to the CSV file containing the Sudoku puzzle.
     * @return  bool    True if the Sudoku puzzle is valid, false otherwise.
     */
    public static function isSudokuPlusValid(string $path): bool
    {
        $rows      = Reader::createFromPath($path, 'r');
        $totalRows = count($rows);

        // Get the square root
        $sqrtResult = sqrt($totalRows);

        // Number of rows is not a perfect square
        if ($totalRows != intval($sqrtResult) * intval($sqrtResult)) {
            return false;
        }

        // Walk all the rows to check columns
        foreach ($rows as $row) {
            $cols = count($row);

            // If cols do not match rows, it's invalid
            if ($cols != $totalRows) {
                return false;
            }
        }

        return $totalRows == $cols;
    }
}

// php bin/console sudoku:validator --filepath=/Users/admin/code/sudoku-5/src/Csv/sudoku.csv
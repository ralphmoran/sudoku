
# Sudoku Plus validator

It checks if the number of rows is a perfect square and then iterates over each row to ensure that each row has the same number of columns as the total number of rows. If any of these conditions fail, the grid is considered invalid.

## Setup

Install dependencies

`$ composer install`

Run web server

`$ php bin/console serve -d or $ symfony serve -d`

## Usage

#### Website

Go to `https://127.0.0.1:8000/show`, it is a simply form to upload a CSV file (only CSV files are accepted).

If the Sudoku Plus file is valid, you'll get a JSON response like:

`{"valid": true}`

Otherwise:

`{"valid": false}`

#### CLI

Open a terminal and go to the working directory then run:

`$ php bin/console sudoku:validator --filepath=/Users/admin/code/sudoku-5/src/Csv/sudoku.csv`

If the Sudoku Plus file is valid, you'll get a JSON response like:

`[OK] The Sudoku Plus file "/Users/admin/code/sudoku-5/src/Csv/sudoku.csv" is valid.`

Otherwise:

`[ERROR] The Sudoku Plus file "/Users/admin/code/sudoku-5/src/Csv/sudoku-invalid.csv" is not valid.`
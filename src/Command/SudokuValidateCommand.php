<?php

namespace App\Command;

use App\Service\SudokuValidatorService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SudokuValidateCommand extends Command
{
    /** @var string Command name */
    protected static $defaultName = 'sudoku:validate';

    protected function configure(): void
    {
        $this->setDescription('Validate a Sudoku Plus CSV file');

        $this->addOption(
            'filepath', 
            null, 
            InputOption::VALUE_REQUIRED, 
            'The absolute file path of the CSV file'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io       = new SymfonyStyle($input, $output);
        $filepath = $input->getOption('filepath');

        // File does not exist
        if (! is_file($filepath)) {
            $io->error(
                sprintf(
                    'CSV File: "%s" does not exist. Make sure you use absolute path.',
                    $filepath
                )
            );

            return Command::FAILURE;
        }

        // Error: The CSV is invalid
        if (! SudokuValidatorService::isSudokuPlusValid($filepath)) {
            $io->error(
                sprintf(
                    'The Sudoku Plus file "%s" is not valid.',
                    $filepath
                )
            );

            return Command::FAILURE;
        }

        // Success
        $io->success(
            sprintf(
                'The Sudoku Plus file "%s" is valid.',
                $filepath
            )
        );

        return Command::SUCCESS;
    }
}

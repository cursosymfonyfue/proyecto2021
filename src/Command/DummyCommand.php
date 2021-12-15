<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// bin/console app:dummy
class DummyCommand extends Command
{
    protected static $defaultName = 'app:dummy';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>I am just a dummy command</info>');

        return Command::SUCCESS;
    }
}

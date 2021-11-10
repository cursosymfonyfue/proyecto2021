<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

// bin/console app:env-var-checked
class EnvVarCheckerCommand extends Command
{
    protected static              $defaultName = 'app:env-var-checked';

    private $version;
    private $maintenance;
    private $signalAsArray;
    private $lastEnvFile;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        parent::__construct();

        $this->version = $parameterBag->get('version');
        $this->maintenance = $parameterBag->get('maintenance');
        $this->signalAsArray = $parameterBag->get('signal_as_array');
        $this->lastEnvFile = $parameterBag->get('last_env_file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("I am just a dummy command!" . PHP_EOL);
        $output->writeln('************************************');

        $output->writeln(sprintf('Is version an integer var? %s', is_numeric($this->version)?'yes':'no'));
        $output->writeln(sprintf('version equals: %s', $this->version));
        $output->writeln('');

        $output->writeln(sprintf('Is maintenance a boolean var? %s', is_bool($this->maintenance)?'yes':'no'));
        $output->writeln(sprintf('maintenance equals: %s', $this->maintenance?'true':'false'));
        $output->writeln('');

        $output->writeln(sprintf('Is signalAsArray an array: %s',  is_array($this->signalAsArray)?'yes':'no'));
        $output->writeln(sprintf('signalAsArray equals: %s',  var_export($this->signalAsArray, true)));
        $output->writeln('');

        $output->writeln(sprintf('Last env file: %s',  $this->lastEnvFile));
        $output->writeln('');

        return Command::SUCCESS;
    }
}

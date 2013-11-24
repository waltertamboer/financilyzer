<?php
/**
 * This file is part of Financilyzer, a tool written to categorize financial transactions.
 *
 * @author Walter Tamboer
 * @copyright (c) 2013, Walter Tamboer
 * @link https://github.com/WalterTamboer/financilyzer for the canonical source repository
 */

namespace Financilyzer\Cli;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends BaseApplication
{
    public function __construct()
    {
        parent::__construct('Financilyzer', '@package_version@');
    }

    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $oldWorkingDirectory = getcwd();
        $this->switchWorkingDir($input);

        $statusCode = parent::doRun($input, $output);

        chdir($oldWorkingDirectory);

        return $statusCode;
    }

    protected function getDefaultCommands()
    {
        $commands = parent::getDefaultCommands();

        $commands[] = new Command\AnalyzeCommand();

        return $commands;
    }

    protected function getDefaultInputDefinition()
    {
        $definition = parent::getDefaultInputDefinition();
        $definition->addOption(new InputOption('--working-dir', '-d', InputOption::VALUE_REQUIRED, 'If specified, use the given directory as working directory.'));
        return $definition;
    }

    private function switchWorkingDir(InputInterface $input)
    {
        $workingDir = $input->getParameterOption(array('--working-dir', '-d'), getcwd());
        if (!is_dir($workingDir)) {
            throw new \RuntimeException('Invalid working directory specified.');
        }
        chdir($workingDir);
    }
}

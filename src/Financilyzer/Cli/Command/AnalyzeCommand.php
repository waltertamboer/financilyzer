<?php

namespace Financilyzer\Cli\Command;

use Financilyzer\Generator\Generator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class AnalyzeCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('analyze');
        $this->addArgument('input', InputArgument::OPTIONAL, 'The path of the financilyzer.xml file.', 'financilyzer.xml');
        $this->addArgument('output', InputArgument::OPTIONAL, 'The path to save the generated data to.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputPath = $input->getArgument('input');
        $outputPath = $input->getArgument('output');
        
        $generator = new Generator();
        
        if ($outputPath) {
            $generator->generateToFile($inputPath, $outputPath);
        } else {
            $output->writeln($generator->generate($inputPath));
        }
    }
}
<?php

namespace Financilyzer\Cli\Command;

use DOMDocument;
use Financilyzer\Transaction\Transaction;
use Financilyzer\Cli\Settings;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AnalyzeCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('analyze');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $outputDom = new DOMDocument();
        $rootNode = $outputDom->createElement('financilyzer');
        $outputDom->appendChild($rootNode);

        $settings = new Settings(realpath('financilyzer.xml'));
        $groups = $settings->getAnalyzers();

        foreach ($settings->getReaders() as $reader) {
            foreach ($reader->getTransactions() as $transaction) {
                if ($this->analyzeTransaction($groups, $transaction)) {
                    $transaction->serialize($rootNode);
                }
            }
        }

        $this->outputReport($settings, $outputDom);
    }

    private function analyzeTransaction(array $groups, Transaction $transaction)
    {
        foreach ($groups as $group) {
            if ($group->analyze($transaction)) {
                $transaction->setCategory($group->getName());
                return true;
            }
        }
        return false;
    }

    private function outputReport(Settings $settings, DOMDocument $dom)
    {
        $transformer = $settings->getTransformer();

        $html = $transformer->transformToXML($dom);

        file_put_contents('transactions.html', $html);
    }

}
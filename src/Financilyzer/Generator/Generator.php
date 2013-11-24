<?php

namespace Financilyzer\Generator;

use DOMDocument;
use Financilyzer\Transaction\Transaction;
use Financilyzer\Generator\Settings;

class Generator
{
    public function generate($inputFile)
    {
        $outputDom = new DOMDocument();
        $rootNode = $outputDom->createElement('financilyzer');
        $outputDom->appendChild($rootNode);

        $settings = new Settings($inputFile);
        $categories = $settings->getAnalyzers();

        foreach ($settings->getReaders() as $reader) {
            foreach ($reader->getTransactions() as $transaction) {
                if ($this->analyzeTransaction($categories, $transaction)) {
                    $transaction->serialize($rootNode);
                }
            }
        }

        return $this->outputReport($settings, $outputDom);
    }

    public function generateToFile($inputFile, $outputFile)
    {
        $data = $this->generate($inputFile);

        file_put_contents($outputFile, $data);
    }

    private function analyzeTransaction(array $categories, Transaction $transaction)
    {
        $result = false;
        foreach ($categories as $category) {
            if ($category->analyze($transaction)) {
                $transaction->addCategory($category->getName());
                $result = true;
            }
        }
        return $result;
    }

    private function outputReport(Settings $settings, DOMDocument $dom)
    {
        $transformer = $settings->getTransformer();

        return $transformer->transformToXML($dom);
    }
}

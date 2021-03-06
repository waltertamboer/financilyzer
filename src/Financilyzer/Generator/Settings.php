<?php
/**
 * This file is part of Financilyzer, a tool written to categorize financial transactions.
 *
 * @author Walter Tamboer
 * @copyright (c) 2013, Walter Tamboer
 * @link https://github.com/WalterTamboer/financilyzer for the canonical source repository
 */

namespace Financilyzer\Generator;

use DOMDocument;
use DOMElement;
use Financilyzer\Analyzer\Factory;
use Financilyzer\Transaction\Account;
use Financilyzer\Transaction\Reader\IngCsv;
use XSLTProcessor;

class Settings
{
    private $accounts;
    private $analyzers;
    private $readers;
    private $transformer;

    public function __construct($path)
    {
        $this->load($path);
    }

    private function load($path)
    {
        $this->accounts = array();
        $this->analyzers = array();
        $this->readers = array();

        $dom = new DOMDocument();
        $dom->load($path);

        $node = $dom->documentElement->firstChild;
        while ($node) {
            if ($node->nodeName == 'accounts') {
                $this->parseAccounts($node);
            } elseif ($node->nodeName == 'readers') {
                $this->parseReaders($node);
            } elseif ($node->nodeName == 'analyzers') {
                $this->parseAnalyzers($node);
            } elseif ($node->nodeName == 'transformer') {
                $this->parseTransformer($node);
            }
            $node = $node->nextSibling;
        }
    }

    private function parseAccounts(DOMElement $parent)
    {
        $node = $parent->firstChild;
        while ($node) {
            if ($node->nodeName == 'account') {
                $this->accounts[] = new Account($node->getAttribute('number'), $node->nodeValue);
            }
            $node = $node->nextSibling;
        }
    }

    private function parseAnalyzers(DOMElement $parent)
    {
        $node = $parent->firstChild;
        while ($node) {
            if ($node->nodeType == XML_ELEMENT_NODE) {
                $analyzer = Factory::factory($node);
                if ($analyzer) {
                    $this->analyzers[] = $analyzer;
                }
            }
            $node = $node->nextSibling;
        }
    }

    private function parseReaders(DOMElement $parent)
    {
        $node = $parent->firstChild;
        while ($node) {
            switch ($node->nodeName) {
                case 'ing-csv':
                    $this->readers[] = new IngCsv($node->nodeValue);
                    break;
            }
            $node = $node->nextSibling;
        }
    }

    private function parseTransformer(DOMElement $parent)
    {
        $path = $parent->getAttribute('path');
        if (!$path) {
            throw new \RuntimeException('No XSL file has been provided.');
        }
        if (!is_file($path)) {
            throw new \RuntimeException('Cannot find .xsl file "' . $path . '"');
        }

        $xsl = new DOMDocument();
        $xsl->load($path);

        $this->transformer = new XSLTProcessor();
        $this->transformer->importStylesheet($xsl);
    }

    public function getAccounts()
    {
        return $this->accounts;
    }

    public function getAnalyzers()
    {
        return $this->analyzers;
    }

    public function getReaders()
    {
        return $this->readers;
    }

    public function getTransformer()
    {
        return $this->transformer;
    }
}

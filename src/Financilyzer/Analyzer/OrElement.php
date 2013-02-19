<?php

namespace Financilyzer\Analyzer;

use Financilyzer\Transaction\Transaction;

class OrElement extends AbstractElement
{
    public function analyze(Transaction $transaction)
    {
        $result = true;

        // One of the child elements must match.
        foreach ($this->getElements() as $element) {
            $result &= $element->analyze($transaction);
        }
        
        return $result;
    }
}

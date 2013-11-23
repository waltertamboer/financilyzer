<?php

namespace Financilyzer\Analyzer;

use Financilyzer\Transaction\Transaction;

class OrElement extends AbstractElement
{
    public function analyze(Transaction $transaction)
    {
        $result = false;
        
        // One of the child elements must match.
        foreach ($this->getElements() as $element) {
            if ($element->analyze($transaction)) {
                $result = true;
                break;
            }
        }
        
        return $result;
    }
}

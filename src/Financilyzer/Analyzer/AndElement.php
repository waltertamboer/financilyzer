<?php

namespace Financilyzer\Analyzer;

use Financilyzer\Transaction\Transaction;

class AndElement extends AbstractElement
{
    public function analyze(Transaction $transaction)
    {
        // All child elements must match:
        foreach ($this->getElements() as $element) {
            if (!$element->analyze($transaction)) {
                return false;
            }
        }
        return true;
    }
}

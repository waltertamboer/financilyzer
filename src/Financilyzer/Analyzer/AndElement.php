<?php
/**
 * This file is part of Financilyzer, a tool written to categorize financial transactions.
 *
 * @author Walter Tamboer
 * @copyright (c) 2013, Walter Tamboer
 * @link https://github.com/WalterTamboer/financilyzer for the canonical source repository
 */

namespace Financilyzer\Analyzer;

use Financilyzer\Transaction\Transaction;

class AndElement extends AbstractElement
{
    public function analyze(Transaction $transaction)
    {
        // All child elements must match. When there are no childs, we fail.
        if (!$this->getElements()) {
            return false;
        }

        foreach ($this->getElements() as $element) {
            if (!$element->analyze($transaction)) {
                return false;
            }
        }

        return true;
    }
}

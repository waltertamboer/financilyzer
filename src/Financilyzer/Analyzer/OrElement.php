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

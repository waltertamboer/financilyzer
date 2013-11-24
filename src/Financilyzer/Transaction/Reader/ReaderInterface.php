<?php
/**
 * This file is part of Financilyzer, a tool written to categorize financial transactions.
 *
 * @author Walter Tamboer
 * @copyright (c) 2013, Walter Tamboer
 * @link https://github.com/WalterTamboer/financilyzer for the canonical source repository
 */

namespace Financilyzer\Transaction\Reader;

/**
 * The interface that should be implemented by all bank file readers.
 */
interface ReaderInterface
{
    /**
     * Gets a list with Transaction objects that are stored in the file.
     *
     * @return Transaction[]
     */
    public function getTransactions();
}

<?php
/**
 * This file is part of Financilyzer, a tool written to categorize financial transactions.
 *
 * @author Walter Tamboer
 * @copyright (c) 2013, Walter Tamboer
 * @link https://github.com/WalterTamboer/financilyzer for the canonical source repository
 */

namespace Financilyzer\Transaction;

/**
 * The representation of a bank account.
 */
class Account
{
    /**
     * The bank account number. We do make a difference between local accounts and IBAN accounts.
     *
     * @var string
     */
    private $number;

    /**
     * The description of this account.
     *
     * @var string
     */
    private $description;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $number The bank account number.
     * @param string $description The description of this account.
     */
    public function __construct($number, $description)
    {
        $this->number = $number;
        $this->description = $description;
    }

    /**
     * Gets the bank account number.
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Gets the description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

}

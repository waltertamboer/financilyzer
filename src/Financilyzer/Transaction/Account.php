<?php
/**
 * This file is part of Financilyzer, a tool written to categorize financial transactions.
 *
 * @author Walter Tamboer
 * @copyright (c) 2013, Walter Tamboer
 * @link https://github.com/WalterTamboer/financilyzer for the canonical source repository
 */

namespace Financilyzer\Transaction;

class Account
{
    private $number;
    private $description;

    public function __construct($number, $description)
    {
        $this->number = $number;
        $this->description = $description;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getDescription()
    {
        return $this->description;
    }

}

<?php
/**
 * This file is part of Financilyzer, a tool written to categorize financial transactions.
 *
 * @author Walter Tamboer
 * @copyright (c) 2013, Walter Tamboer
 * @link https://github.com/WalterTamboer/financilyzer for the canonical source repository
 */

namespace FinancilyzerTest\Transaction;

use Financilyzer\Transaction\Account;

class AccountTest extends \PHPUnit_Framework_TestCase
{
    public function testGetNumber()
    {
        $account = new Account(123, 'description');
        $this->assertEquals(123, $account->getNumber());
    }

    public function testGetDescription()
    {
        $account = new Account(123, 'description');
        $this->assertEquals('description', $account->getDescription());
    }
}

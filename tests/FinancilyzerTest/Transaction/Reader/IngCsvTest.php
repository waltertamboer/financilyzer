<?php

namespace FinancilyzerTest\Transaction\Reader;

use Financilyzer\Transaction\Reader\IngCsv;
use Financilyzer\Transaction\Transaction;

class IngCsvTest extends \PHPUnit_Framework_TestCase
{
    public function testGetTransactions()
    {
        $reader = new IngCsv('tests/assets/banks/ing.csv');
        $this->assertCount(1, $reader->getTransactions());
    }

    public function testGetTransactionsLoadTwice()
    {
        $reader = new IngCsv('tests/assets/banks/ing.csv');
        $this->assertCount(1, $reader->getTransactions());
        $this->assertCount(1, $reader->getTransactions());
    }

    /**
     * @expectedException RuntimeException
     */
    public function testLoadInvalidSyntax()
    {
        $reader = new IngCsv('tests/assets/banks/ing-valid.csv');
        $this->assertCount(0, $reader->getTransactions());
    }

    public function testTransactionTypes()
    {
        $reader = new IngCsv('tests/assets/banks/ing-transaction-types.csv');

        $transactions = $reader->getTransactions();
        $this->assertCount(12, $transactions);

        $this->assertSame(Transaction::TYPE_ATM, $transactions[0]->getType());
        $this->assertSame(Transaction::TYPE_CHEQUE, $transactions[1]->getType());
        $this->assertSame(Transaction::TYPE_COLLECTION_PAYMENT, $transactions[2]->getType());
        $this->assertSame(Transaction::TYPE_DEBT_COLLECTION, $transactions[3]->getType());
        $this->assertSame(Transaction::TYPE_DEPOSIT, $transactions[4]->getType());
        $this->assertSame(Transaction::TYPE_INTEREST, $transactions[5]->getType());
        $this->assertSame(Transaction::TYPE_INTERNET, $transactions[6]->getType());
        $this->assertSame(Transaction::TYPE_OTHER, $transactions[7]->getType());
        $this->assertSame(Transaction::TYPE_PAPERCHECK, $transactions[8]->getType());
        $this->assertSame(Transaction::TYPE_PHONE, $transactions[9]->getType());
        $this->assertSame(Transaction::TYPE_PIN, $transactions[10]->getType());
        $this->assertSame(Transaction::TYPE_TRANSFER, $transactions[11]->getType());
    }

    /**
     * @expectedException RuntimeException
     */
    public function testInvalidTransactionType()
    {
        $reader = new IngCsv('tests/assets/banks/ing-invalid-transaction-type.csv');

        $transactions = $reader->getTransactions();
        $this->assertCount(1, $transactions);
    }
}

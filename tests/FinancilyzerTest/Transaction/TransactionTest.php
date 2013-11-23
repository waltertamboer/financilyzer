<?php

namespace FinancilyzerTest\Transaction;

use Financilyzer\Transaction\Transaction;

class TransactionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDate()
    {
        $transaction = new Transaction();
        $this->assertNull($transaction->getDate());
    }

    public function testSetDate()
    {
        $transaction = new Transaction();
        $this->assertNull($transaction->getDate());
        
        $transaction->setDate(new \DateTime('2013-11-01'));
        $this->assertInstanceOf('DateTime', $transaction->getDate());
        $this->assertSame('2013-11-01', $transaction->getDate()->format('Y-m-d'));
    }

    public function testGetType()
    {
        $transaction = new Transaction();
        $this->assertNull($transaction->getType());
    }

    public function testSetType()
    {
        $transaction = new Transaction();
        $this->assertNull($transaction->getType());
        
        $transaction->setType(Transaction::TYPE_TRANSFER);
        $this->assertSame(Transaction::TYPE_TRANSFER, $transaction->getType());
    }

    public function testAddCategory()
    {
        $transaction = new Transaction();
        $this->assertCount(0, $transaction->getCategories());
        
        $transaction->addCategory('category1');
        $this->assertCount(1, $transaction->getCategories());
        
        $transaction->addCategory('category2');
        $this->assertCount(2, $transaction->getCategories());
    }

    public function testGetCategories()
    {
        $transaction = new Transaction();
        $this->assertCount(0, $transaction->getCategories());
        
        $transaction->addCategory('category1');
        $transaction->addCategory('category2');
        
        $this->assertSame(array('category1', 'category2'), $transaction->getCategories());
    }

    public function testGetAmount()
    {
        $transaction = new Transaction();
        $this->assertEquals(0, $transaction->getAmount());
    }

    public function testSetAmount()
    {
        $transaction = new Transaction();
        $this->assertEquals(0, $transaction->getAmount());
        
        $transaction->setAmount(12.34);
        $this->assertEquals(12.34, $transaction->getAmount());
    }

    public function testGetName()
    {
        $transaction = new Transaction();
        $this->assertSame('', $transaction->getName());
    }

    public function testSetName()
    {
        $transaction = new Transaction();
        $this->assertSame('', $transaction->getName());
        
        $transaction->setName('Test');
        $this->assertSame('Test', $transaction->getName());
    }

    public function testGetDescription()
    {
        $transaction = new Transaction();
        $this->assertSame('', $transaction->getDescription());
    }

    public function testSetDescription()
    {
        $transaction = new Transaction();
        $this->assertSame('', $transaction->getDescription());
        
        $transaction->setDescription('Test');
        $this->assertSame('Test', $transaction->getDescription());
    }

    public function testGetFrom()
    {
        $transaction = new Transaction();
        $this->assertSame('', $transaction->getFrom());
        
        $transaction->setFrom('Test');
        $this->assertSame('Test', $transaction->getFrom());
    }

    public function testSetFrom()
    {
        $transaction = new Transaction();
        $this->assertSame('', $transaction->getFrom());
        
        $transaction->setFrom('Test');
        $this->assertSame('Test', $transaction->getFrom());
    }

    public function testGetTo()
    {
        $transaction = new Transaction();
        $this->assertSame('', $transaction->getTo());
    }

    public function testSetTo()
    {
        $transaction = new Transaction();
        $this->assertSame('', $transaction->getTo());
        
        $transaction->setTo('Test');
        $this->assertSame('Test', $transaction->getTo());
    }

    public function testGetHash()
    {
        $transaction = new Transaction();
        $this->assertSame('d41d8cd98f00b204e9800998ecf8427e', $transaction->getHash());
        
        $transaction->setName('name');
        $this->assertSame('b068931cc450442b63f5b3d276ea4297', $transaction->getHash());
        
        $transaction->setDescription('description');
        $this->assertSame('e53feab7e8808d96fb3bab5f56741596', $transaction->getHash());
        
        $transaction->setDate(new \DateTime('2013-01-01'));
        $this->assertSame('a5ee7a446c1bcb1d35a65c9b91490d32', $transaction->getHash());
    }

    public function testSerializeEmpty()
    {
        $dom = new \DOMDocument();
        $dom->formatOutput = true;
        $root = $dom->createElement('root');
        $dom->appendChild($root);
        
        $transaction = new Transaction();
        $transaction->serialize($root);
        $this->assertStringEqualsFile('tests/assets/serialized/empty.xml', $dom->saveXML());
    }

    public function testSerializeFilled()
    {
        $dom = new \DOMDocument();
        $dom->formatOutput = true;
        $root = $dom->createElement('root');
        $dom->appendChild($root);
        
        $transaction = new Transaction();
        $transaction->setName('name');
        $transaction->setDescription('description');
        $transaction->serialize($root);
        $this->assertStringEqualsFile('tests/assets/serialized/filled.xml', $dom->saveXML());
    }
}

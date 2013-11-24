<?php
/**
 * This file is part of Financilyzer, a tool written to categorize financial transactions.
 *
 * @author Walter Tamboer
 * @copyright (c) 2013, Walter Tamboer
 * @link https://github.com/WalterTamboer/financilyzer for the canonical source repository
 */

namespace FinancilyzerTest\Analyzer;

use Financilyzer\Analyzer\AnalyzerElement;
use Financilyzer\Transaction\Transaction;

class AnalyzerElementTest extends \PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $element = new AnalyzerElement();
        $this->assertNull($element->getName());
    }

    public function testSetName()
    {
        $element = new AnalyzerElement();
        $this->assertNull($element->getName());

        $element->setName('name');
        $this->assertSame('name', $element->getName());
    }

    public function testGetValue()
    {
        $element = new AnalyzerElement();
        $this->assertNull($element->getValue());
    }

    public function testSetValue()
    {
        $element = new AnalyzerElement();
        $this->assertNull($element->getValue());

        $element->setValue('value');
        $this->assertSame('value', $element->getValue());
    }

    public function testGetCompareMode()
    {
        $element = new AnalyzerElement();
        $this->assertNull($element->getCompareMode());
    }

    public function testSetCompareMode()
    {
        $element = new AnalyzerElement();
        $this->assertNull($element->getCompareMode());

        $element->setCompareMode(AnalyzerElement::COMPARE_EQUALS);
        $this->assertSame(AnalyzerElement::COMPARE_EQUALS, $element->getCompareMode());

        $element->setCompareMode(AnalyzerElement::COMPARE_MATCHES);
        $this->assertSame(AnalyzerElement::COMPARE_MATCHES, $element->getCompareMode());
    }

    /**
     * @expectedException RuntimeException
     */
    public function testAnalyzeEmptyTransactionEmptyAnalyzer()
    {
        $transaction = new Transaction();

        $element = new AnalyzerElement();
        $element->analyze($transaction);
    }

    public function testAnalyzeEmptyTransactionInvalidAnalyzer()
    {
        $transaction = new Transaction();

        $element = new AnalyzerElement();
        $element->setName('to');
        $element->setCompareMode('invalid');
        $this->assertFalse($element->analyze($transaction));
    }

    public function testAnalyzeEmptyTransactionEqualsAnalyzer()
    {
        $transaction = new Transaction();

        $element = new AnalyzerElement();
        $element->setName('to');
        $element->setCompareMode(AnalyzerElement::COMPARE_EQUALS);
        $element->setValue('123');
        $this->assertFalse($element->analyze($transaction));
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testAnalyzeEmptyTransactionInvalidPatternAnalyzer()
    {
        $transaction = new Transaction();

        $element = new AnalyzerElement();
        $element->setName('to');
        $element->setCompareMode(AnalyzerElement::COMPARE_MATCHES);
        $element->setValue('123');
        $this->assertFalse($element->analyze($transaction));
    }

    public function testAnalyzeEmptyTransactionValidPatternAnalyzer()
    {
        $transaction = new Transaction();
        $transaction->setTo('123456');

        $element = new AnalyzerElement();
        $element->setName('to');
        $element->setCompareMode(AnalyzerElement::COMPARE_MATCHES);
        $element->setValue('/123.56/');
        $this->assertTrue($element->analyze($transaction));
    }

    public function testAnalyzeTo()
    {
        $transaction = new Transaction();
        $transaction->setTo('test');

        $element = new AnalyzerElement();
        $element->setName('to');
        $element->setCompareMode(AnalyzerElement::COMPARE_EQUALS);
        $element->setValue('test');
        $this->assertTrue($element->analyze($transaction));
    }

    public function testAnalyzeFrom()
    {
        $transaction = new Transaction();
        $transaction->setFrom('test');

        $element = new AnalyzerElement();
        $element->setName('from');
        $element->setCompareMode(AnalyzerElement::COMPARE_EQUALS);
        $element->setValue('test');
        $this->assertTrue($element->analyze($transaction));
    }

    // TODO: Implement more dynamic rules.
}

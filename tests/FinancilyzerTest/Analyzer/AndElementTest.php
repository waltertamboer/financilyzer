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
use Financilyzer\Analyzer\AndElement;
use Financilyzer\Transaction\Transaction;

class AndElementTest extends \PHPUnit_Framework_TestCase
{
    public function testAnalyzeNoChilds()
    {
        $transaction = new Transaction();

        $element = new AndElement();
        $this->assertFalse($element->analyze($transaction));
    }

    public function testAnalyzeOneChild()
    {
        $transaction = new Transaction();
        $transaction->setTo('test');

        $child = new AnalyzerElement();
        $child->setName('to');
        $child->setValue('test');
        $child->setCompareMode(AnalyzerElement::COMPARE_EQUALS);

        $element = new AndElement();
        $element->addChild($child);
        $this->assertTrue($element->analyze($transaction));
    }

    public function testAnalyzeTwoChildsOneMatches()
    {
        $transaction = new Transaction();
        $transaction->setTo('test');

        $element = new AndElement();

        $child1 = new AnalyzerElement();
        $child1->setName('to');
        $child1->setValue('test');
        $child1->setCompareMode(AnalyzerElement::COMPARE_EQUALS);
        $element->addChild($child1);

        $child2 = new AnalyzerElement();
        $child2->setName('to');
        $child2->setValue('test2');
        $child2->setCompareMode(AnalyzerElement::COMPARE_EQUALS);
        $element->addChild($child2);

        $this->assertFalse($element->analyze($transaction));
    }

    public function testAnalyzeTwoDifferentChilds()
    {
        $transaction = new Transaction();
        $transaction->setTo('test');

        $element = new AndElement();

        $child1 = new AnalyzerElement();
        $child1->setName('to');
        $child1->setValue('test1');
        $child1->setCompareMode(AnalyzerElement::COMPARE_EQUALS);
        $element->addChild($child1);

        $child2 = new AnalyzerElement();
        $child2->setName('to');
        $child2->setValue('test2');
        $child2->setCompareMode(AnalyzerElement::COMPARE_EQUALS);
        $element->addChild($child2);

        $this->assertFalse($element->analyze($transaction));
    }

    public function testAnalyzeTwoSameChilds()
    {
        $transaction = new Transaction();
        $transaction->setTo('test');

        $element = new AndElement();

        $child1 = new AnalyzerElement();
        $child1->setName('to');
        $child1->setValue('test');
        $child1->setCompareMode(AnalyzerElement::COMPARE_EQUALS);
        $element->addChild($child1);

        $child2 = new AnalyzerElement();
        $child2->setName('to');
        $child2->setValue('test');
        $child2->setCompareMode(AnalyzerElement::COMPARE_EQUALS);
        $element->addChild($child2);

        $this->assertTrue($element->analyze($transaction));
    }
}

<?php

namespace FinancilyzerTest\Analyzer;

use Financilyzer\Analyzer\AnalyzerElement;
use Financilyzer\Analyzer\OrElement;
use Financilyzer\Transaction\Transaction;

class OrElementTest extends \PHPUnit_Framework_TestCase
{
    public function testAnalyzeNoChilds()
    {
        $transaction = new Transaction();

        $element = new OrElement();
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

        $element = new OrElement();
        $element->addChild($child);
        $this->assertTrue($element->analyze($transaction));
    }

    public function testAnalyzeTwoChilds()
    {
        $transaction = new Transaction();
        $transaction->setTo('test');

        $element = new OrElement();

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

        $this->assertTrue($element->analyze($transaction));
    }

    public function testAnalyzeTwoInvalidChilds()
    {
        $transaction = new Transaction();
        $transaction->setTo('test');

        $element = new OrElement();

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
}

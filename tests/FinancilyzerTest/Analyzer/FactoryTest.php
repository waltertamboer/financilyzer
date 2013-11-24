<?php
/**
 * This file is part of Financilyzer, a tool written to categorize financial transactions.
 *
 * @author Walter Tamboer
 * @copyright (c) 2013, Walter Tamboer
 * @link https://github.com/WalterTamboer/financilyzer for the canonical source repository
 */

namespace FinancilyzerTest\Analyzer;

use DOMDocument;
use Financilyzer\Analyzer\AnalyzerElement;
use Financilyzer\Analyzer\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testAndFactory()
    {
        $dom = new DOMDocument();
        $node = $dom->createElement('and');

        $this->assertInstanceOf('Financilyzer\Analyzer\AndElement', Factory::factory($node));
    }

    public function testOrFactory()
    {
        $dom = new DOMDocument();
        $node = $dom->createElement('or');

        $this->assertInstanceOf('Financilyzer\Analyzer\OrElement', Factory::factory($node));
    }

    public function testCategoryFactory()
    {
        $dom = new DOMDocument();
        $node = $dom->createElement('category');

        $this->assertInstanceOf('Financilyzer\Analyzer\CategoryElement', Factory::factory($node));
    }

    public function testToEqualsElementFactory()
    {
        $dom = new DOMDocument();
        $node = $dom->createElement('to');
        $node->setAttribute('equals', 'value');

        $element = Factory::factory($node);

        $this->assertInstanceOf('Financilyzer\Analyzer\AnalyzerElement', $element);
        $this->assertSame('to', $element->getName());
        $this->assertSame(AnalyzerElement::COMPARE_EQUALS, $element->getCompareMode());
    }

    public function testToMatchesElementFactory()
    {
        $dom = new DOMDocument();
        $node = $dom->createElement('to');
        $node->setAttribute('matches', '/.+/i');

        $element = Factory::factory($node);

        $this->assertInstanceOf('Financilyzer\Analyzer\AnalyzerElement', $element);
        $this->assertSame('to', $element->getName());
        $this->assertSame(AnalyzerElement::COMPARE_MATCHES, $element->getCompareMode());

    }
}

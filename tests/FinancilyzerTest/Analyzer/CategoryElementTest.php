<?php
/**
 * This file is part of Financilyzer, a tool written to categorize financial transactions.
 *
 * @author Walter Tamboer
 * @copyright (c) 2013, Walter Tamboer
 * @link https://github.com/WalterTamboer/financilyzer for the canonical source repository
 */

namespace FinancilyzerTest\Analyzer;

use Financilyzer\Analyzer\CategoryElement;

class CategoryElementTest extends \PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $element = new CategoryElement();
        $this->assertNull($element->getName());
    }

    public function testSetName()
    {
        $element = new CategoryElement();
        $this->assertNull($element->getName());

        $element->setName('test');
        $this->assertSame('test', $element->getName());
    }
}

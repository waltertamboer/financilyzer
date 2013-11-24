<?php

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

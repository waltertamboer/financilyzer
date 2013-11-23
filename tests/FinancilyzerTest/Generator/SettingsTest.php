<?php

namespace FinancilyzerTest\Generator;

use Financilyzer\Generator\Settings;

class SettingsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testConstructorNoParameter()
    {
        new Settings();
    }
    
    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testConstructorEmptyPath()
    {
        new Settings('');
    }
    
    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testConstructorInvalidPath()
    {
        new Settings('path');
    }
    
    /**
     * @expectedException RuntimeException
     */
    public function testConstructorNoXSL()
    {
        new Settings('assets/settings/financilyzer-empty.xml');
    }
    
    /**
     * @expectedException RuntimeException
     */
    public function testConstructorInvalidXSL()
    {
        new Settings('assets/settings/financilyzer-invalid-xsl.xml');
    }
    
    public function testConstructorWithPath()
    {
        new Settings('assets/settings/financilyzer.xml');
    }
    
    public function testGetAccounts()
    {
        $settings = new Settings('assets/settings/financilyzer.xml');
        $this->assertCount(1, $settings->getAccounts());
    }

    public function testGetAnalyzers()
    {
        $settings = new Settings('assets/settings/financilyzer.xml');
        $this->assertCount(2, $settings->getAnalyzers());
    }

    public function testGetReaders()
    {
        $settings = new Settings('assets/settings/financilyzer.xml');
        $this->assertCount(1, $settings->getReaders());
    }

    public function testGetTransformer()
    {
        $settings = new Settings('assets/settings/financilyzer.xml');
        $readers = $settings->getReaders();
        
        $this->assertCount(1, $readers);
        $this->assertSame('assets/banks/ing.csv', $readers[0]->getPath());
    }
}
<?php

namespace FinancilyzerTest\Generator;

use Financilyzer\Generator\Generator;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        parent::tearDown();
        
        if (is_file('generated.xml')) {
            unlink('generated.xml');
        }
    }
    
    public function testGenerate()
    {
        $generator = new Generator();
        
        $this->assertEquals(
                '<html xmlns:fn="http://www.w3.org/2005/xpath-functions">123</html>' . "\n", 
                $generator->generate('assets/settings/financilyzer.xml'));
    }
    
    public function testGenerateToFile()
    {
        $generator = new Generator();
        $this->assertFileNotExists('generated.xml');
        
        $generator->generateToFile('assets/settings/financilyzer.xml', 'generated.xml');
        $this->assertFileExists('generated.xml');
        
        $this->assertStringEqualsFile('generated.xml', 
                $generator->generate('assets/settings/financilyzer.xml'));
    }
}

<?php
/**
 * This file is part of Financilyzer, a tool written to categorize financial transactions.
 *
 * @author Walter Tamboer
 * @copyright (c) 2013, Walter Tamboer
 * @link https://github.com/WalterTamboer/financilyzer for the canonical source repository
 */

namespace Financilyzer\Analyzer;

abstract class AbstractElement
{
    private $childs;

    public function __construct()
    {
        $this->childs = array();
    }

    public function addChild(AbstractElement $element)
    {
        $this->childs[] = $element;
    }

    public function getElements()
    {
        return $this->childs;
    }
}

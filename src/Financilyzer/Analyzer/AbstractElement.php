<?php

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

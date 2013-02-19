<?php

namespace Financilyzer\Analyzer;

use DOMElement;

class Factory
{
    public static function factory(DOMElement $parent)
    {
        $result = null;

        if ($parent->nodeName == 'group') {
            $result = self::groupFactory($parent);
        } elseif ($parent->nodeName == 'and') {
            $result = self::andFactory($parent);
        } elseif ($parent->nodeName == 'or') {
            $result = self::orFactory($parent);
        } else {
            $result = self::elementFactory($parent);
        }

        if ($result) {
            $node = $parent->firstChild;
            while ($node) {
                if ($node->nodeType == XML_ELEMENT_NODE) {
                    $childElement = self::factory($node);
                    $result->addChild($childElement);
                }
                $node = $node->nextSibling;
            }
        }

        return $result;
    }

    public static function andFactory(DOMElement $node)
    {
        return new AndElement();
    }

    public static function orFactory(DOMElement $node)
    {
        return new OrElement();
    }

    public static function groupFactory(DOMElement $node)
    {
        $result = new GroupElement();

        $result->setName($node->getAttribute('name'));

        return $result;
    }

    public static function elementFactory(DOMElement $node)
    {
        $result = new AnalyzerElement();

        $result->setName($node->nodeName);

        if ($node->hasAttribute('equals')) {
            $result->setValue($node->getAttribute('equals'));
            $result->setCompareMode(AnalyzerElement::COMPARE_EQUALS);
        } elseif ($node->hasAttribute('matches')) {
            $result->setValue($node->getAttribute('matches'));
            $result->setCompareMode(AnalyzerElement::COMPARE_MATCHES);
        }

        return $result;
    }
}

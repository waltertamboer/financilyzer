<?php
/**
 * This file is part of Financilyzer, a tool written to categorize financial transactions.
 *
 * @author Walter Tamboer
 * @copyright (c) 2013, Walter Tamboer
 * @link https://github.com/WalterTamboer/financilyzer for the canonical source repository
 */

namespace Financilyzer\Analyzer;

use DOMElement;

class Factory
{
    public static function factory(DOMElement $parent)
    {
        $result = null;

        if ($parent->nodeName == 'category') {
            $result = self::categoryFactory($parent);
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

    private static function andFactory(DOMElement $node)
    {
        return new AndElement();
    }

    private static function orFactory(DOMElement $node)
    {
        return new OrElement();
    }

    private static function categoryFactory(DOMElement $node)
    {
        $result = new CategoryElement();

        $result->setName($node->getAttribute('name'));

        return $result;
    }

    private static function elementFactory(DOMElement $node)
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

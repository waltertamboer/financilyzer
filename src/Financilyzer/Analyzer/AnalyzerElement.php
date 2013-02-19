<?php

namespace Financilyzer\Analyzer;

use Financilyzer\Transaction\Transaction;

class AnalyzerElement extends AndElement
{
    const COMPARE_EQUALS = 'equals';
    const COMPARE_MATCHES = 'pattern';

    private $name;
    private $value;
    private $compareMode;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getCompareMode()
    {
        return $this->compareMode;
    }

    public function setCompareMode($compareMode)
    {
        $this->compareMode = $compareMode;
    }

    public function analyze(Transaction $transaction)
    {
        $getter = 'get' . ucfirst($this->name);
        $value = call_user_func(array($transaction, $getter));

        switch ($this->compareMode) {
            case self::COMPARE_EQUALS:
                $result = $this->value == $value;
                break;

            case self::COMPARE_MATCHES:
                $result = preg_match($this->value, $value);
                break;

            default:
                $result = false;
                break;
        }

        return $result;
    }
}

<?php

namespace Financilyzer\Analyzer;

use Financilyzer\Transaction\Transaction;

class GroupElement extends AndElement
{
    private $name;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function analyze(Transaction $transaction)
    {
        return parent::analyze($transaction);
    }
}

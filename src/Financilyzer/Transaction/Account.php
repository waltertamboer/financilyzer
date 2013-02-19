<?php

namespace Financilyzer\Transaction;

class Account
{
    private $number;
    private $description;

    public function __construct($number, $description)
    {
        $this->number = $number;
        $this->description = $description;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getDescription()
    {
        return $this->description;
    }
}

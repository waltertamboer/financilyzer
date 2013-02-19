<?php

namespace Financilyzer\Transaction\Reader;

abstract class AbstractReader implements ReaderInterface
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }
}

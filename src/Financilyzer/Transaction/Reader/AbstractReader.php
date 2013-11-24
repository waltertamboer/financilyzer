<?php
/**
 * This file is part of Financilyzer, a tool written to categorize financial transactions.
 *
 * @author Walter Tamboer
 * @copyright (c) 2013, Walter Tamboer
 * @link https://github.com/WalterTamboer/financilyzer for the canonical source repository
 */

namespace Financilyzer\Transaction\Reader;

/**
 * The base class for all bank file readers.
 */
abstract class AbstractReader implements ReaderInterface
{
    /**
     * The path of where the file is located.
     *
     * @var string
     */
    private $path;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $path The path to read.
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Gets the path to read.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}

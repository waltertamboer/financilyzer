<?php
/**
 * This file is part of Financilyzer, a tool written to categorize financial transactions.
 *
 * @author Walter Tamboer
 * @copyright (c) 2013, Walter Tamboer
 * @link https://github.com/WalterTamboer/financilyzer for the canonical source repository
 */

namespace Financilyzer\Transaction;

use DateTime;
use DOMElement;

/**
 * The representation of a financial transaction.
 */
class Transaction
{
    /*
     * TODO: Make these codes more generic so we have bank-unspecific codes.
     *
     * ING CODES:
     * AC Acceptgiro
     * BA Betaalautomaat
     * CH Cheque
     * DV Diversen
     * GF Telefonisch Bankieren
     * GM Geldautomaat
     * GT Internetbankieren
     * IC Incasso
     * OV Overschrijving
     * PK Opname Kantoor
     * PO Periodieke overschrijving
     * R Rente
     * RV Reservering
     * ST Storting
     * VZ Verzamelbetaling
     */
    const TYPE_ATM = 'atm'; /** ING: GM Geldautomaat */
    const TYPE_CHEQUE = 'cheque'; /** ING: CH Cheque */
    const TYPE_COLLECTION_PAYMENT = 'collectionPayment'; /** ING: VZ Verzamelbetaling */
    const TYPE_DEPOSIT = 'deposit'; /** ING: ST Storting */
    const TYPE_DEBT_COLLECTION = 'debtcollection'; /** ING: IC Incasso */
    const TYPE_INTEREST = 'interest'; /** ING: R Rente */
    const TYPE_INTERNET = 'internet'; /** ING: GT Internetbankieren */
    const TYPE_OTHER = 'other'; /** ING: DV Diversen */
    const TYPE_PHONE = 'phone'; /** ING: GF Telefonisch Bankieren */
    const TYPE_PAPERCHECK = 'papercheck'; /** ING: AC Acceptgiro */
    const TYPE_PIN = 'pin'; /** ING: BA Betaalautomaat */
    const TYPE_TRANSFER = 'transfer'; /** ING: OV Overschrijving */

    /**
     * The date of when this transaction did occur.
     *
     * @var DateTime
     */
    private $date;

    /**
     * The type of the transaction.
     *
     * @var string
     */
    private $type;

    /**
     * A string array with all categories that this transaction has.
     *
     * @var string[]
     */
    private $categories;

    /**
     * The name of the transaction.
     *
     * @var string
     */
    private $name;

    /**
     * The description of the transaction.
     *
     * @var string
     */
    private $description;

    /**
     * The transaction amount.
     *
     * TODO: It's unsafe to use float, it's better to use an integer (amount * 100)
     * @var float
     */
    private $amount;

    /**
     * The account number the transaction was done by. This can be null incase of automatic withdrawal.
     *
     * @var string
     */
    private $from;

    /**
     * The account number the transaction was sent to. This can be null.
     *
     * @var string
     */
    private $to;

    /**
     * Initializes a new instance of this class.
     */
    public function __construct()
    {
        $this->categories = array();
    }

    /**
     * Gets the date of when this transaction happened.
     *
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the date of when this transaction happened.
     *
     * @param string|DateTime $date The date to set.
     * @return Transaction
     */
    public function setDate($date)
    {
        if ($date instanceof DateTime) {
            $this->date = $date;
        } else {
            $this->date = new DateTime($date);
        }
        return $this;
    }

    /**
     * Gets the type of this transaction.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type of this transaction.
     *
     * @param string $type This should be one of the constants defined in this class.
     * @return Transaction
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Adds a category to this transaction.
     *
     * @param string $category The category to add.
     * @return Transaction
     */
    public function addCategory($category)
    {
        $this->categories[] = $category;
        return $this;
    }

    /**
     * Gets the string list with categories.
     *
     * @return string[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Gets the amount that was transferred with this transaction.
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Sets the amount that was transferred with this transaction.
     *
     * @param float $amount The amount to set.
     * @return Transaction
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Gets the name of the transaction.
     *
     * @return string
     */
    public function getName()
    {
        return (string)$this->name;
    }

    /**
     * Sets the name of the transaction.
     *
     * @param string $name The name to set.
     * @return Transaction
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Gets the description of the transaction.
     *
     * @return string
     */
    public function getDescription()
    {
        return (string)$this->description;
    }

    /**
     * Sets the description of the transaction.
     *
     * @param string $description The description to set.
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Gets the account number the transaction comes from.
     *
     * @return string
     */
    public function getFrom()
    {
        return (string)$this->from;
    }

    /**
     * Sets the account number the transaction comes from.
     *
     * @return string The account number to set.
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Gets the account number the transaction was sent to.
     *
     * @return string
     */
    public function getTo()
    {
        return (string)$this->to;
    }

    /**
     * Sets the account number the transaction was sent to.
     *
     * @param string $to The account number to set.
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * Generates a hash of this transaction. This is used for caching transactions.
     *
     * @return string
     */
    public function getHash()
    {
        $hash = '';

        if ($this->getDate()) {
            $hash .= $this->getDate()->format('dmYHis');
        }
        $hash .= $this->getName();
        $hash .= $this->getDescription();

        return md5($hash);
    }

    /**
     * Serializes this transaction to the given DOM element.
     *
     * @param DOMElement $parent The DOM node to append the transaction to.
     */
    public function serialize(DOMElement $parent)
    {
        $dom = $parent->ownerDocument;

        $transactionElement = $dom->createElement('transaction');
        $parent->appendChild($transactionElement);

        $element = $dom->createElement('type');
        $element->appendChild($dom->createTextNode($this->getType()));
        $transactionElement->appendChild($element);

        $element = $dom->createElement('categories');
        $element->appendChild($dom->createTextNode(implode(', ', $this->getCategories())));
        $transactionElement->appendChild($element);

        $element = $dom->createElement('date');
        if ($this->getDate()) {
            $element->appendChild($dom->createTextNode($this->getDate()->format('r')));
        }
        $transactionElement->appendChild($element);

        $element = $dom->createElement('from');
        $element->appendChild($dom->createTextNode($this->getFrom()));
        $transactionElement->appendChild($element);

        $element = $dom->createElement('to');
        $element->appendChild($dom->createTextNode($this->getTo()));
        $transactionElement->appendChild($element);

        $element = $dom->createElement('amount');
        $element->appendChild($dom->createTextNode($this->getAmount()));
        $transactionElement->appendChild($element);

        $element = $dom->createElement('name');
        $element->appendChild($dom->createTextNode($this->getName()));
        $transactionElement->appendChild($element);

        $element = $dom->createElement('description');
        $element->appendChild($dom->createTextNode($this->getDescription()));
        $transactionElement->appendChild($element);
    }
}

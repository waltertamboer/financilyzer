<?php

namespace Financilyzer\Transaction;

use DateTime;
use DOMElement;

class Transaction
{
    /*
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

    private $date;
    private $type;
    private $category;
    private $name;
    private $description;
    private $amount;
    private $from;
    private $to;

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = new DateTime($date);
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    public function getHash()
    {
        $hash = '';

        $hash .= $this->getDate()->format('dmYHis');
        $hash .= $this->getName();
        $hash .= $this->getDescription();

        return md5($hash);
    }

    public function serialize(DOMElement $parent)
    {
        $dom = $parent->ownerDocument;

        $transactionElement = $dom->createElement('transaction');
        $parent->appendChild($transactionElement);

        $element = $dom->createElement('type');
        $element->appendChild($dom->createTextNode($this->getType()));
        $transactionElement->appendChild($element);

        $element = $dom->createElement('category');
        $element->appendChild($dom->createTextNode($this->getCategory()));
        $transactionElement->appendChild($element);

        $element = $dom->createElement('date');
        $element->appendChild($dom->createTextNode($this->getDate()->format('r')));
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

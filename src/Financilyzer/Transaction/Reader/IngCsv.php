<?php

namespace Financilyzer\Transaction\Reader;

use Financilyzer\Transaction\Transaction;
use RuntimeException;

class IngCsv extends AbstractReader
{
    private $transactions;

    private function load()
    {
        if ($this->transactions) {
            return;
        }

        $this->transactions = array();

        // Read the file into an array and strip off the descriptions:
        $lines = file($this->getPath());
        array_shift($lines);

        foreach ($lines as $line) {
            $this->parseTransaction($line);
        }
    }

    private function parseTransaction($data)
    {
        if (!preg_match_all('/"([^"]*)",?/i', $data, $matches)) {
            throw new RuntimeException('Failed to parse the transaction: ' . $data);
        }

        $transaction = new Transaction();
        $transaction->setDate($matches[1][0]);
        $transaction->setName(trim($matches[1][1]));
        $transaction->setDescription(trim($matches[1][8]));

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
        switch (trim($matches[1][4])) {
            case 'AC':
                $transaction->setType(Transaction::TYPE_PAPERCHECK);
                break;

            case 'BA':
                $transaction->setType(Transaction::TYPE_PIN);
                break;

            case 'CH':
                $transaction->setType(Transaction::TYPE_CHEQUE);
                break;

            case 'DV':
                $transaction->setType(Transaction::TYPE_OTHER);
                break;

            case 'GF':
                $transaction->setType(Transaction::TYPE_PHONE);
                break;

            case 'GM':
                $transaction->setType(Transaction::TYPE_ATM);
                break;

            case 'GT':
                $transaction->setType(Transaction::TYPE_INTERNET);
                break;

            case 'IC':
                $transaction->setType(Transaction::TYPE_DEBT_COLLECTION);
                break;

            case 'OV':
                $transaction->setType(Transaction::TYPE_TRANSFER);
                break;

            case 'R':
                $transaction->setType(Transaction::TYPE_INTEREST);
                break;

            case 'ST':
                $transaction->setType(Transaction::TYPE_DEPOSIT);
                break;

            case 'VZ':
                $transaction->setType(Transaction::TYPE_COLLECTION_PAYMENT);
                break;

            default:
                throw new \RuntimeException('Unsupported transaction type: ' . trim($matches[1][4]));
        }

        $sender = trim($matches[1][2]);
        $receiver = trim($matches[1][3]);

        $amount = (float)str_replace(',', '.', $matches[1][6]);
        if (strtolower($matches[1][5]) == 'af') {
            $transaction->setAmount(-$amount);

            // In case you pulled money from an ATM:
            if (!$receiver) {
                $transaction->setFrom($sender);
            } else {
                $transaction->setFrom($sender);
                $transaction->setTo($receiver);
            }
        } else {
            $transaction->setAmount($amount);

            if (!$receiver) {
                $transaction->setFrom($sender);
            } else {
                $transaction->setFrom($receiver);
                $transaction->setTo($sender);
            }
        }

        $this->transactions[] = $transaction;
    }

    public function getTransactions()
    {
        $this->load();
        return $this->transactions;
    }

}

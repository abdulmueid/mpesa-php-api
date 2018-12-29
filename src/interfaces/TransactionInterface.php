<?php
/**
 * @author      Abdul Mueid Akhtar <abdul.mueid@gmail.com>
 * @copyright   Copyright (c) Abdul Mueid akhtar
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/abdulmueid/mpesa-php-api
 */

namespace abdulmueid\mpesa\interfaces;

/**
 * Interface TransactionInterface
 * @package abdulmueid\mpesa\interfaces
 */
interface TransactionInterface
{
    /**
     * Initiates a payment transaction on the M-Pesa C2B API
     * @param string $msisdn
     * @param float $amount
     * @param string $reference
     * @param string $third_party_reference
     * @return TransactionResponseInterface
     */
    public function payment(string $msisdn, float $amount, string $reference, string $third_party_reference): TransactionResponseInterface;

    /**
     * Initiates the refund of a transaction on the M-Pesa Reversal API
     * @param string $transaction_id
     * @param float $amount
     * @return TransactionResponseInterface
     */
    public function refund(string $transaction_id, float $amount): TransactionResponseInterface;

    /**
     * Queries the status of a transaction on the M-Pesa Query Transaction Status API
     * @param string $query_reference
     * @return TransactionResponseInterface
     */
    public function query(string $query_reference): TransactionResponseInterface;
}
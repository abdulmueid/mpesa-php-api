<?php
/**
 * TransactionInterface
 *
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
     * Initiates a C2B transaction on the M-Pesa API.
     * @param float $amount
     * @param string $msisdn
     * @param string $reference
     * @param string $third_party_reference
     * @return TransactionResponseInterface
     */
    public function c2b(float $amount, string $msisdn, string $reference, string $third_party_reference): TransactionResponseInterface;

    /**
     * Initiates a B2C transaction on the M-Pesa API.
     * @param float $amount
     * @param string $msisdn
     * @param string $reference
     * @param string $third_party_reference
     * @return TransactionResponseInterface
     */
    public function b2c(float $amount, string $msisdn, string $reference, string $third_party_reference): TransactionResponseInterface;

    /**
     * Initiates a B2B transaction on the M-Pesa API.
     * @param float $amount
     * @param string $receiver_party_code
     * @param string $reference
     * @param string $third_party_reference
     * @return TransactionResponseInterface
     */
    public function b2b(float $amount, string $receiver_party_code, string $reference, string $third_party_reference): TransactionResponseInterface;

    /**
     * Initiates a transaction Reversal on the M-Pesa API.
     * @param float $amount
     * @param string $transaction_id
     * @param string $third_party_reference
     * @return TransactionResponseInterface
     */
    public function reversal(float $amount, string $transaction_id, string $third_party_reference): TransactionResponseInterface;

    /**
     * Initiates a transaction Query on the M-Pesa API.
     * @param string $query_reference
     * @param string $third_party_reference
     * @return TransactionResponseInterface
     */
    public function query(string $query_reference, string $third_party_reference): TransactionResponseInterface;
}
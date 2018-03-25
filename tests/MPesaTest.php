<?php
/**
 * @author      Abdul Mueid Akhtar <abdul.mueid@gmail.com>
 * @copyright   Copyright (c) Abdul Mueid akhtar
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/abdulmueid/mpesa
 */

use abdulmueid\mpesa\Config;
use abdulmueid\mpesa\interfaces\TransactionResponseInterface;

class MPesaTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \abdulmueid\mpesa\interfaces\TransactionInterface
     */
    private $transaction;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $msisdn;

    protected function setUp()
    {
        $config = Config::loadFromFile(__DIR__ . '/config.test.php');
        $this->transaction = new \abdulmueid\mpesa\Transaction($config);
        $this->amount = 1;
        $this->msisdn = ''; // Full MSISDN i.e. 258840000000
    }

    /**
     * @return TransactionResponseInterface
     * @throws Exception
     */
    public function testPayment(): TransactionResponseInterface
    {

        $payment = $this->transaction->payment(
            $this->msisdn,
            $this->amount,
            bin2hex(random_bytes(6)),
            bin2hex(random_bytes(6))
        );
        $this->assertInstanceOf(
            \abdulmueid\mpesa\TransactionResponse::class,
            $payment
        );
        $this->assertNotEmpty($payment->getResponse());
        $this->assertNotEmpty($payment->getCode());
        $this->assertNotEmpty($payment->getDescription());
        $this->assertNotEmpty($payment->getTransactionID());
        $this->assertNotEmpty($payment->getConversationID());
        $this->assertEmpty($payment->getTransactionStatus());
        $this->assertStringStartsWith('INS-', $payment->getCode());
        return $payment;
    }

    /**
     * @depends testPayment
     * @param $payment TransactionResponseInterface
     * @return TransactionResponseInterface
     */
    public function testRefund(TransactionResponseInterface $payment): TransactionResponseInterface
    {
        $refund = $this->transaction->refund($payment->getTransactionID(), $this->amount);
        $this->assertInstanceOf(
            \abdulmueid\mpesa\TransactionResponse::class,
            $refund
        );
        $this->assertNotEmpty($refund->getResponse());
        $this->assertNotEmpty($refund->getCode());
        $this->assertNotEmpty($refund->getDescription());
        $this->assertNotEmpty($refund->getTransactionID());
        $this->assertNotEmpty($refund->getConversationID());
        $this->assertEmpty($refund->getTransactionStatus());
        $this->assertStringStartsWith('INS-', $refund->getCode());
        return $refund;
    }

    /**
     * @depends testRefund
     * @param $refund TransactionResponseInterface
     */
    public function testQuery(TransactionResponseInterface $refund)
    {
        $query = $this->transaction->query($refund->getTransactionID());
        $this->assertInstanceOf(
            \abdulmueid\mpesa\TransactionResponse::class,
            $query
        );
        $this->assertNotEmpty($query->getResponse());
        $this->assertNotEmpty($query->getCode());
        $this->assertNotEmpty($query->getDescription());
        $this->assertEmpty($query->getTransactionID());
        $this->assertEmpty($query->getConversationID());
        $this->assertNotEmpty($query->getTransactionStatus());
        $this->assertStringStartsWith('INS-', $query->getCode());
    }

}
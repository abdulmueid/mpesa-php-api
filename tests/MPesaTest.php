<?php
/**
 * @author      Abdul Mueid Akhtar <abdul.mueid@gmail.com>
 * @copyright   Copyright (c) Abdul Mueid akhtar
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/abdulmueid/mpesa-php-api
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

    /**
     * @var string
     */
    private $b2b_receiver;

    /**
     * @return TransactionResponseInterface
     * @throws Exception
     */
    public function testB2C(): TransactionResponseInterface
    {

        $payment = $this->transaction->b2c(
            $this->amount,
            $this->msisdn,
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
     * @return TransactionResponseInterface
     * @throws Exception
     */
    public function testB2B(): TransactionResponseInterface
    {

        $payment = $this->transaction->b2b(
            $this->amount,
            $this->b2b_receiver,
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
     * @return TransactionResponseInterface
     * @throws Exception
     */
    public function testC2B(): TransactionResponseInterface
    {

        $payment = $this->transaction->c2b(
            $this->amount,
            $this->msisdn,
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
     * @depends testC2B
     * @param $payment TransactionResponseInterface
     * @return TransactionResponseInterface
     * @throws Exception
     */
    public function testReversal(TransactionResponseInterface $payment): TransactionResponseInterface
    {
        $refund = $this->transaction->reversal(
            $this->amount,
            $payment->getTransactionID(),
            bin2hex(random_bytes(6))
        );
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
     * @depends testReversal
     * @param $refund TransactionResponseInterface
     * @throws Exception
     */
    public function testQuery(TransactionResponseInterface $refund)
    {
        $query = $this->transaction->query(
            $refund->getTransactionID(),
            bin2hex(random_bytes(6))
        );
        $this->assertInstanceOf(
            \abdulmueid\mpesa\TransactionResponse::class,
            $query
        );
        $this->assertNotEmpty($query->getResponse());
        $this->assertNotEmpty($query->getCode());
        $this->assertNotEmpty($query->getDescription());
        $this->assertEmpty($query->getTransactionID());
        $this->assertNotEmpty($query->getConversationID());
        $this->assertNotEmpty($query->getTransactionStatus());
        $this->assertStringStartsWith('INS-', $query->getCode());
    }

    protected function setUp(): void
    {
        $config = Config::loadFromFile(__DIR__ . '/config.test.php');
        $this->transaction = new \abdulmueid\mpesa\Transaction($config);
        $this->amount = 1;
        $this->msisdn = getenv('MPESA_CUSTOMER_MSISDN'); // Full MSISDN i.e. 258840000000
        $this->b2b_receiver = getenv('MPESA_B2B_RECEIVER');
    }
}
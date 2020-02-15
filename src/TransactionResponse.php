<?php
/**
 * TransactionResponse parses all incoming responses from M-Pesa and provides the information in a clean way
 *
 * @author      Abdul Mueid Akhtar <abdul.mueid@gmail.com>
 * @copyright   Copyright (c) Abdul Mueid akhtar
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/abdulmueid/mpesa-php-api
 */

namespace abdulmueid\mpesa;

use abdulmueid\mpesa\interfaces\TransactionResponseInterface;

/**
 * Class TransactionResponse
 * @package abdulmueid\mpesa
 */
class TransactionResponse implements TransactionResponseInterface
{
    /**
     * Full response from the M-Pesa API
     * @var string
     */
    private $response;

    /**
     * Response Code from M-Pesa API
     * @var string
     */
    private $code;

    /**
     * Response Description from M-Pesa API
     * @var string
     */
    private $description;

    /**
     * Transaction ID from M-Pesa Payment and Refund API
     * @var string
     */
    private $transaction_id;

    /**
     * Conversation ID from M-Pesa Payment and Refund API
     * @var string
     */
    private $conversation_id;

    /**
     * Transaction Status from M-Pesa Query API
     * @var string
     */
    private $transaction_status;

    /**
     * TransactionResponse constructor.
     * @param string $response
     */
    public function __construct(string $response)
    {
        $this->response = $response;
        $params = json_decode($this->response, true);
        $this->code = $params['output_ResponseCode'] ?? '';
        $this->description = $params['output_ResponseDesc'] ?? '';
        $this->transaction_id = $params['output_TransactionID'] ?? '';
        $this->conversation_id = $params['output_ConversationID'] ?? '';
        $this->transaction_status = $params['output_ResponseTransactionStatus'] ?? '';
    }

    /**
     * Returns the Response Code
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Returns the response description
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Returns the TransactionID
     * @return string
     */
    public function getTransactionID(): string
    {
        return $this->transaction_id;
    }

    /**
     * Returns the Conversation ID
     * @return string
     */
    public function getConversationID(): string
    {
        return $this->conversation_id;
    }

    /**
     * Returns the Transaction Status from Query API
     * @return string
     */
    public function getTransactionStatus(): string
    {
        return $this->transaction_status;
    }

    /**
     * Returns the raw response from M-Pesa API
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
    }
}
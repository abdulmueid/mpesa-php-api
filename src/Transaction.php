<?php
/**
 * @author      Abdul Mueid Akhtar <abdul.mueid@gmail.com>
 * @copyright   Copyright (c) Abdul Mueid akhtar
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/abdulmueid/mpesa-php-api
 */

namespace abdulmueid\mpesa;

use abdulmueid\mpesa\interfaces\ConfigInterface;
use abdulmueid\mpesa\interfaces\TransactionInterface;
use abdulmueid\mpesa\interfaces\TransactionResponseInterface;
use abdulmueid\mpesa\helpers\ValidationHelper;

/**
 * Class Transaction
 * @package abdulmueid\mpesa
 */
class Transaction implements TransactionInterface
{
    /**
     * The configuration class
     * @var ConfigInterface
     */
    private $config;

    /**
     * Transaction constructor.
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Initiates a payment transaction on the M-Pesa C2B API.
     * @param string $msisdn
     * @param float $amount
     * @param string $reference
     * @param string $third_party_reference
     * @return TransactionResponseInterface
     * @throws \Exception
     */
    public function payment(
        string $msisdn,
        float $amount,
        string $reference,
        string $third_party_reference): TransactionResponseInterface
    {
        $msisdn = ValidationHelper::normalizeMSISDN($msisdn);
        $amount = round($amount, 2);
        $payload = [
            'input_ServiceProviderCode' => $this->config->getServiceProviderCode(),
            'input_CustomerMSISDN' => $msisdn,
            'input_Amount' => $amount,
            'input_TransactionReference' => $reference,
            'input_ThirdPartyReference' => $third_party_reference
        ];
        $payload = json_encode($payload);
        $request_handle = curl_init('https://' . $this->config->getApiHost() . ':18346/ipg/v1/c2bpayment/');
        curl_setopt($request_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request_handle, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload),
            'Origin: ' . $this->config->getOrigin(),
            'Authorization: ' . $this->config->getBearerToken()
        ]);
        curl_setopt($request_handle, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($request_handle, CURLOPT_POSTFIELDS, $payload);
        $result = curl_exec($request_handle);
       
        if ($result === false) 
            $result = curl_error($request_handle);
        
        return new TransactionResponse($result);
    }

    /**
     * Initiates the refund of a transaction on the M-Pesa Reversal API
     * @param string $transaction_id
     * @param float $amount
     * @return TransactionResponseInterface
     */
    public function refund(string $transaction_id, float $amount): TransactionResponseInterface
    {
        $amount = round($amount, 2);
        $payload = [
            'input_ServiceProviderCode' => $this->config->getServiceProviderCode(),
            'input_Amount' => $amount,
            'input_InitiatorIdentifier' => $this->config->getInitiatorIdentifier(),
            'input_SecurityCredential' => $this->config->getSecurityCredential(),
            'input_TransactionID' => $transaction_id
        ];

        $payload = json_encode($payload);
        $request_handle = curl_init('https://' . $this->config->getApiHost() . ':18348/ipg/v1/reversal/');
        curl_setopt($request_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request_handle, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload),
            'Origin: ' . $this->config->getOrigin(),
            'Authorization: ' . $this->config->getBearerToken()
        ]);
        curl_setopt($request_handle, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($request_handle, CURLOPT_POSTFIELDS, $payload);
        $result = curl_exec($request_handle);
        
        if ($result === false) 
            $result = curl_error($request_handle);
        
        return new TransactionResponse($result);
    }

    /**
     * Queries the status of a transaction on the M-Pesa Query Transaction Status API
     * @param string $query_reference
     * @return TransactionResponseInterface
     */
    public function query(string $query_reference): TransactionResponseInterface
    {
        $payload = [
            'input_ServiceProviderCode' => $this->config->getServiceProviderCode(),
            'input_InitiatorIdentifier' => $this->config->getInitiatorIdentifier(),
            'input_SecurityCredential' => $this->config->getSecurityCredential(),
            'input_QueryReference' => $query_reference
        ];
        $payload = http_build_query($payload);
        $request_handle = curl_init('https://' . $this->config->getApiHost() . ':18347/ipg/v1/queryTxn/?' . $payload);
        curl_setopt($request_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request_handle, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Origin: ' . $this->config->getOrigin(),
            'Authorization: ' . $this->config->getBearerToken()
        ]);
        $result = curl_exec($request_handle);
        
        if ($result === false) 
            $result = curl_error($request_handle);
        
        return new TransactionResponse($result);
    }
}

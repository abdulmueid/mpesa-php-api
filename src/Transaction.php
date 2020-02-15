<?php
/**
 * Transaction Class implements all API calls as per Transaction Interface
 *
 * @author      Abdul Mueid Akhtar <abdul.mueid@gmail.com>
 * @copyright   Copyright (c) Abdul Mueid akhtar
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/abdulmueid/mpesa-php-api
 */

namespace abdulmueid\mpesa;

use abdulmueid\mpesa\helpers\ValidationHelper;
use abdulmueid\mpesa\interfaces\ConfigInterface;
use abdulmueid\mpesa\interfaces\TransactionInterface;
use abdulmueid\mpesa\interfaces\TransactionResponseInterface;
use Exception;

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
     * Initiates a C2B transaction on the M-Pesa API.
     * @param float $amount
     * @param string $msisdn
     * @param string $reference
     * @param string $third_party_reference
     * @return TransactionResponseInterface
     * @throws Exception
     */
    public function c2b(
        float $amount,
        string $msisdn,
        string $reference,
        string $third_party_reference
    ): TransactionResponseInterface
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
        $request_handle = curl_init(
            'https://' . $this->config->getApiHost() . ':18352/ipg/v1x/c2bPayment/singleStage/'
        );
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
        return new TransactionResponse($result);
    }

    /**
     * Initiates a B2C transaction on the M-Pesa API.
     * @param float $amount
     * @param string $msisdn
     * @param string $reference
     * @param string $third_party_reference
     * @return TransactionResponseInterface
     * @throws Exception
     */
    public function b2c(
        float $amount,
        string $msisdn,
        string $reference,
        string $third_party_reference
    ): TransactionResponseInterface
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
        $request_handle = curl_init(
            'https://' . $this->config->getApiHost() . ':18345/ipg/v1x/b2cPayment/'
        );
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
        return new TransactionResponse($result);
    }

    /**
     * Initiates a B2B transaction on the M-Pesa API.
     * @param float $amount
     * @param string $receiver_party_code
     * @param string $reference
     * @param string $third_party_reference
     * @return TransactionResponseInterface
     */
    public function b2b(
        float $amount,
        string $receiver_party_code,
        string $reference,
        string $third_party_reference
    ): TransactionResponseInterface
    {
        $amount = round($amount, 2);
        $payload = [
            'input_Amount' => $amount,
            'input_TransactionReference' => $reference,
            'input_ThirdPartyReference' => $third_party_reference,
            'input_PrimaryPartyCode' => $this->config->getServiceProviderCode(),
            'input_ReceiverPartyCode' => $receiver_party_code,
        ];
        $payload = json_encode($payload);
        $request_handle = curl_init(
            'https://' . $this->config->getApiHost() . ':18349/ipg/v1x/b2bPayment/'
        );
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
        return new TransactionResponse($result);
    }

    /**
     * Initiates a Reversal transaction on the M-Pesa API.
     * @param float $amount
     * @param string $transaction_id
     * @param string $third_party_reference
     * @return TransactionResponseInterface
     */
    public function reversal(
        float $amount,
        string $transaction_id,
        string $third_party_reference
    ): TransactionResponseInterface
    {
        $amount = round($amount, 2);
        $payload = [
            'input_Amount' => $amount,
            'input_TransactionID' => $transaction_id,
            'input_ThirdPartyReference' => $third_party_reference,
            'input_ServiceProviderCode' => $this->config->getServiceProviderCode(),
            'input_InitiatorIdentifier' => $this->config->getInitiatorIdentifier(),
            'input_SecurityCredential' => $this->config->getSecurityCredential(),

        ];

        $payload = json_encode($payload);
        $request_handle = curl_init('https://' . $this->config->getApiHost() . ':18354/ipg/v1x/reversal/');
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
        return new TransactionResponse($result);
    }

    /**
     * Initiates a transaction Query on the M-Pesa API.
     * @param string $query_reference
     * @param string $third_party_reference
     * @return TransactionResponseInterface
     */
    public function query(
        string $query_reference,
        string $third_party_reference
    ): TransactionResponseInterface
    {
        $payload = [
            'input_QueryReference' => $query_reference,
            'input_ServiceProviderCode' => $this->config->getServiceProviderCode(),
            'input_ThirdPartyReference' => $third_party_reference
        ];
        $payload = http_build_query($payload);
        $request_handle = curl_init(
            'https://' . $this->config->getApiHost() . ':18353/ipg/v1x/queryTransactionStatus/?' . $payload
        );
        curl_setopt($request_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request_handle, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Origin: ' . $this->config->getOrigin(),
            'Authorization: ' . $this->config->getBearerToken()
        ]);
        $result = curl_exec($request_handle);
        return new TransactionResponse($result);
    }
}
<?php
/**
 * Config provides a standard way to get/set required M-Pesa parameters and generate Bearer Tokens
 *
 * @author      Abdul Mueid Akhtar <abdul.mueid@gmail.com>
 * @copyright   Copyright (c) Abdul Mueid akhtar
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/abdulmueid/mpesa-php-api
 */

namespace abdulmueid\mpesa;

use abdulmueid\mpesa\interfaces\ConfigInterface;

/**
 * Class Config
 * @package abdulmueid\mpesa
 */
class Config implements ConfigInterface
{
    /**
     * Public Key for the M-Pesa API. Used for generating Authorization bearer tokens.
     * @var string
     */
    private $public_key;

    /**
     * Hostname for the API - Use Sandbox or Production hostname
     * @var string
     */
    private $api_host;
    /**
     * API Key for the M-Pesa API. Used for creating authorize trasactions on the API
     * @var string
     */
    private $api_key;

    /**
     * Origin Header - Used for identifying hostname which is sending transaction requests
     * @var string
     */
    private $origin;

    /**
     * Service Provider Code - Provided by Vodacom
     * @var string
     */
    private $service_provider_code;

    /**
     * Initiator Identifier - Provided by Vodacom
     * @var string
     */
    private $initiator_identifier;

    /**
     * Security Credential - Provided by Vodacom
     * @var string
     */
    private $security_credential;

    /**
     * Config constructor.
     * @param string $public_key
     * @param string $api_host
     * @param string $api_key
     * @param string $origin
     * @param string $service_provider_code
     * @param string $initiator_identifier
     * @param string $security_credential
     */
    public function __construct(
        string $public_key,
        string $api_host,
        string $api_key,
        string $origin,
        string $service_provider_code,
        string $initiator_identifier,
        string $security_credential
    )
    {
        $this->public_key = $public_key;
        $this->api_host = $api_host;
        $this->api_key = $api_key;
        $this->origin = $origin;
        $this->service_provider_code = $service_provider_code;
        $this->initiator_identifier = $initiator_identifier;
        $this->security_credential = $security_credential;
    }

    /**
     * Loads the configuration from a file and returns a Config instance
     * @param string $file_path
     * @return Config
     */
    public static function loadFromFile(string $file_path)
    {
        $config = require $file_path;
        return new Config(
            $config['public_key'],
            $config['api_host'],
            $config['api_key'],
            $config['origin'],
            $config['service_provider_code'],
            $config['initiator_identifier'],
            $config['security_credential']
        );
    }

    /**
     * Encrypts the API key with public key and returns a usable Bearer Token
     *
     * @return string
     */
    public function getBearerToken(): string
    {
        $key = "-----BEGIN PUBLIC KEY-----\n";
        $key .= wordwrap($this->getPublicKey(), 60, "\n", true);
        $key .= "\n-----END PUBLIC KEY-----";
        $pk = openssl_get_publickey($key);
        openssl_public_encrypt($this->getApiKey(), $token, $pk, OPENSSL_PKCS1_PADDING);
        return 'Bearer ' . base64_encode($token);
    }

    /**
     * Returns M-Pesa Public Key
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->public_key;
    }

    /**
     * Returns API Hostname
     * @return string
     */
    public function getApiHost(): string
    {
        return $this->api_host;
    }

    /**
     * Returns API Key
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->api_key;
    }

    /**
     * Returns Origin
     * @return string
     */
    public function getOrigin(): string
    {
        return $this->origin;
    }

    /**
     * Returns Service Provider Code
     * @return string
     */
    public function getServiceProviderCode(): string
    {
        return $this->service_provider_code;
    }

    /**
     * Returns Initiator Identifier
     * @return string
     */
    public function getInitiatorIdentifier(): string
    {
        return $this->initiator_identifier;
    }

    /**
     * Returns Security Credential
     * @return string
     */
    public function getSecurityCredential(): string
    {
        return $this->security_credential;
    }
}
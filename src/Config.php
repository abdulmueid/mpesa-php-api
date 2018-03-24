<?php
/**
 * @author      Abdul Mueid Akhtar <abdul.mueid@gmail.com>
 * @copyright   Copyright (c) Abdul Mueid akhtar
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/abdulmueid/mpesa
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
     * API Key for the M-Pesa API. Used for creating authorize trasactions on the API
     * @var string
     */
    private $api_key;

    /**
     * @var string
     */
    private $service_provider_code;

    /**
     * @var string
     */
    private $initiator_identifier;

    /**
     * @var string
     */
    private $security_credential;

    /**
     * Config constructor.
     * @param string $public_key
     * @param string $api_key
     * @param string $service_provider_code
     * @param string $initiator_identifier
     * @param string $security_credential
     */
    public function __construct(
        string $public_key,
        string $api_key,
        string $service_provider_code,
        string $initiator_identifier,
        string $security_credential
    )
    {
        $this->public_key = $public_key;
        $this->api_key = $api_key;
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
            $config['api_key'],
            $config['service_provider_code'],
            $config['initiator_identifier'],
            $config['security_credential']
        );
    }

    /**
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->public_key;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->api_key;
    }

    /**
     * @return string
     */
    public function getServiceProviderCode(): string
    {
        return $this->service_provider_code;
    }

    /**
     * @return string
     */
    public function getInitiatorIdentifier(): string
    {
        return $this->initiator_identifier;
    }

    /**
     * @return string
     */
    public function getSecurityCredential(): string
    {
        return $this->security_credential;
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
}
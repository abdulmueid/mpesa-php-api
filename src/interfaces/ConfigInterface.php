<?php
/**
 * @author      Abdul Mueid Akhtar <abdul.mueid@gmail.com>
 * @copyright   Copyright (c) Abdul Mueid akhtar
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/abdulmueid/mpesa
 */

namespace abdulmueid\mpesa\interfaces;

/**
 * Interface ConfigInterface
 * @package abdulmueid\mpesa\interfaces
 */
interface ConfigInterface
{

    /**
     * Returns the Public Key
     *
     * @return string
     */
    public function getPublicKey(): string;

    /**
     * Returns the API Key
     *
     * @return string
     */
    public function getApiKey(): string;

    /**
     * Returns the Service Provider Code
     *
     * @return string
     */
    public function getServiceProviderCode(): string;

    /**
     * Returns the Initiator Identifier
     *
     * @return string
     */
    public function getInitiatorIdentifier(): string;

    /**
     * 	Returns the Security Credential
     * @return string
     */
    public function getSecurityCredential(): string;

    /**
     * Encrypts the API key with public key and returns a usable Bearer Token
     *
     * @return string
     */
    public function getBearerToken(): string;
}
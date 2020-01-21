<?php
/**
 * @author      Abdul Mueid Akhtar <abdul.mueid@gmail.com>
 * @copyright   Copyright (c) Abdul Mueid akhtar
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/abdulmueid/mpesa-php-api
 */

return [
    'public_key' => getenv('MPESA_PUBLIC_KEY'),
    'api_host' => getenv('MPESA_API_HOST'),
    'api_key' => getenv('MPESA_API_KEY'),
    'origin' => getenv('MPESA_ORIGIN'),
    'service_provider_code' => getenv('MPESA_SERVICE_PROVIDER_CODE'),
    'initiator_identifier' => getenv('MPESA_INITIATOR_IDENTIFIER'),
    'security_credential' => getenv('MPESA_SECURITY_CREDENTIAL')
];
<?php
/**
 * ValidationHelper validates and normalizes MSISDN as per ITU E.164 standard
 *
 * @author      Kishan Nareshpal Jadav <kishan_jadav@hotmail.com | https://kishannareshpal.github.io>
 * @copyright   Copyright (c) Kishan Nareshpal Jadav
 *
 * @license     http://mit-license.org/
 * @link        https://github.com/abdulmueid/mpesa-php-api
 */

namespace abdulmueid\mpesa\helpers;

use Exception;

/**
 * Class ValidationHelper
 * @package abdulmueid\mpesa\helpers
 */
class ValidationHelper
{
    /**
     * Validates and normalizes the MSISDN to 25884|5xxxxxxx as accepted by the M-Pesa API.
     * – Restricts MSISDN to only Vodacom Prefixes (84, 85).
     * – Accepts MSISDN in the following formats:
     *      * (84|85)xxxxxxx
     *      * 258(84|85)xxxxxxx
     *      * +258(84|85)xxxxxxx
     *      * 00258(84|85)xxxxxxx
     *
     * @param string $msisdn msisdn which will be validated and normalized afterwards.
     * @return string normalized phone number: 258(84|85)xxxxxxx
     * @throws Exception
     */
    public static function normalizeMSISDN($msisdn)
    {
        // $matchGroup array contains 5 pairs:
        // – [0] -> the full match.
        // – [1] -> starts with + or 00.
        // – [2] -> the country code 258.
        // – [3] -> the phone number without the country code. Includes the local prefix.
        // – [4] -> the local prefix, either 84 or 85.
        $matchGroup = array();
        $isValid = preg_match('/^(\+|00)?(258)?((84|85)\d{7})$/', $msisdn, $matchGroup);

        if ($isValid) {
            // $match = $matchGroup[0];
            // $containsPlusOrZeroZero = $matchGroup[1] != null;
            // $containsCountryCode    = $matchGroup[2] != null;
            // $containsLocalPrefix    = $matchGroup[4] != null;
            $matchedPhoneNumber = $matchGroup[3];
            $normalizedPhoneNumber = "258" . $matchedPhoneNumber;
            return $normalizedPhoneNumber;
        } else {
            throw new Exception("The provided number " . $msisdn . " is not valid Vodacom MSISDN.");
        }
    }
}
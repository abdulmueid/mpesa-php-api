<?php
/**
 * @author      Abdul Mueid Akhtar <abdul.mueid@gmail.com>
 * @copyright   Copyright (c) Abdul Mueid akhtar
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/abdulmueid/mpesa-php-api
 */

use abdulmueid\mpesa\helpers\ValidationHelper;
use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase
{
    private $validMSISDNs;
    private $invalidStrings;

    /**
     * @return bool
     * @throws Exception
     */
    public function testValidMSISDNs()
    {
        foreach ($this->validMSISDNs as $msisdn) {
            $this->assertIsString(ValidationHelper::normalizeMSISDN($msisdn));
        }
        return true;
    }

    /**
     * @return bool
     */
    public function testInvalidStrings()
    {
        foreach ($this->invalidStrings as $string) {
            $invalidString = true;
            try {
                ValidationHelper::normalizeMSISDN($string); // Should throw exception
                $invalidString = false;
            } catch (Exception $e) {
            }
            $this->assertTrue($invalidString, $string . " is not supposed to be valid");
        }
        return true;
    }

    protected function setUp(): void
    {
        // Set up valid MSISDNs
        $this->validMSISDNs = [];
        $this->validMSISDNs[] = "841231234";
        $this->validMSISDNs[] = "258841231234";
        $this->validMSISDNs[] = "+258841231234";
        $this->validMSISDNs[] = "00258841231234";
        $this->validMSISDNs[] = "851231234";
        $this->validMSISDNs[] = "258851231234";
        $this->validMSISDNs[] = "+258851231234";
        $this->validMSISDNs[] = "00258851231234";

        // Set up invalid strings
        $this->invalidStrings = [];
        // Short Length
        $this->invalidStrings[] = "84123123";
        $this->invalidStrings[] = "25884123123";
        $this->invalidStrings[] = "+25884123123";
        $this->invalidStrings[] = "0025884123123";
        // Long Length
        $this->invalidStrings[] = "8412312345";
        $this->invalidStrings[] = "2588412312345";
        $this->invalidStrings[] = "+2588412312345";
        $this->invalidStrings[] = "002588412312345";
        // Mcel prefixes - 82, 83
        $this->invalidStrings[] = "821231234";
        $this->invalidStrings[] = "258821231234";
        $this->invalidStrings[] = "+258821231234";
        $this->invalidStrings[] = "00258821231234";
        $this->invalidStrings[] = "831231234";
        $this->invalidStrings[] = "258831231234";
        $this->invalidStrings[] = "+258831231234";
        $this->invalidStrings[] = "00258831231234";
        // Movitel prefixes - 86, 87
        $this->invalidStrings[] = "861231234";
        $this->invalidStrings[] = "258861231234";
        $this->invalidStrings[] = "+258861231234";
        $this->invalidStrings[] = "00258861231234";
        $this->invalidStrings[] = "871231234";
        $this->invalidStrings[] = "258871231234";
        $this->invalidStrings[] = "+258871231234";
        $this->invalidStrings[] = "00258871231234";
    }
}

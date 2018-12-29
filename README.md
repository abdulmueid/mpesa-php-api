# PHP library for M-Pesa API (Mozambique)

This library provides easy way to integrate PHP applications with the M-Pesa API.

## Installation

Install using composer:
```
composer require abdulmueid/mpesa
```

## Usage

1. Load the configuration from file.
    ```php
    $config = \abdulmueid\mpesa\Config::loadFromFile('/path/to/config.php');
    ```
    See sample configuration file in examples folder.

2. Create a Transaction using the configuration.
    ```php
    $transaction = new \abdulmueid\mpesa\Transaction($config);
    ```
    
3. Execute API operations and pass appropriate parameters. 

    (See Class documentation in docs/ folder for parameter details.)

    1. Initiate a payment.
        ```php
        $payment = $transaction->payment(...);
        ```
    
    2. Initiate a refund.
        ```php
        $refund = $transaction->refund(...);
        ```
    
    3. Query a transaction.
        ```php
        $query = $transaction->query(...);
        ```
        
## Testing
1. Update tests/config.test.php with required parameters
2. Enter the test MSISDN in tests/MPesaTest.php on line 35
3. Run **PHPUnit 7** phar archive in the project folder (https://phar.phpunit.de/phpunit-7.phar)
4. Check the phone for M-Pesa payment requests

The test case currently creates a new transaction, queries the transaction status and refunds the transaction.
**Tests may be billable when running on production.**

## Generating Docs
1. Run **phpDocumentor 2.9** phar archive in the project folder (http://phpdoc.org/phpDocumentor.phar)

## License

This library is release under the MIT License. See LICENSE file for details.

## TODO

1. Improve documentation
2. Add more examples
3. Improve test suite and test automation
# PHP library for M-Pesa API (Mozambique)

This library provides easy way to integrate PHP applications with the M-Pesa API.

## NOTICE

Currently, this library is only usable if you are in the M-Pesa test group and have access to the API portal and credentials.

The M-Pesa API is quickly evolving. Therefore the code is currently for testing purposes only and will evolve with the M-Pesa API until it reaches a stable state.

**DO NOT USE IN PRODUCTION!**

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

2. Create a Transaction using the configuration.
    ```php
    $transaction = new \abdulmueid\mpesa\Transaction($config);
    ```
    See sample configuration file in examples folder.
    
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
        
## TODO

1. Improve documentation
2. Add more examples
3. Improve test suite and test automation
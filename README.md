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

    1. Initiate a C2B payment collection.
        ```php
        $c2b = $transaction->c2b(...);
        ```
        
    2. Initiate a B2C payment.
        ```php
        $b2c = $transaction->b2c(...);
        ```
        
    3. Initiate a B2B payment.
        ```php
        $b2b = $transaction->b2b(...);
        ```
    
    2. Initiate a reversal.
        ```php
        $reversal = $transaction->reversal(...);
        ```
    
    3. Query a transaction.
        ```php
        $query = $transaction->query(...);
        ```
        
## License

This library is release under the MIT License. See LICENSE file for details.

## TODO

1. Rewrite Tests - Current Tests Broken
2. Generate Docs
2. Add more examples
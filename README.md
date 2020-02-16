# Welcome to M-Pesa PHP API

This project aims to provide an easy-to-use and up-to-date PHP wrapper for the M-Pesa Mozambique API.

Target version of M-Pesa API: **v1x**

## Installation

Install using composer:
```
composer require abdulmueid/mpesa:2.0.0-beta1
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

    1. Initiate a C2B payment collection.
       ```php
       $c2b = $transaction->c2b(
           float $amount,
           string $msisdn,
           string $reference,
           string $third_party_reference
       );
        ```
        
    2. Initiate a B2C payment.
       ```php
       $b2c = $transaction->b2c(
           float $amount,
           string $msisdn,
           string $reference,
           string $third_party_reference
       );
       ```
        
    3. Initiate a B2B payment.
       ```php
       $b2b = $transaction->b2b(
            float $amount,
            string $receiver_party_code,
            string $reference,
            string $third_party_reference
       );
       ```
    
    2. Initiate a reversal.
       ```php
       $reversal = $transaction->reversal(
           float $amount,  
           string $transaction_id,
           string $third_party_reference
       );
       ```
    
    3. Query a transaction.
       ```php
       $query = $transaction->query(
           string $query_reference,
           string $third_party_reference
       );
       ```
        
## License

This library is release under the MIT License. See LICENSE file for details.
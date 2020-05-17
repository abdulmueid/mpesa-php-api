# Welcome to M-Pesa PHP API

This project aims to provide an easy-to-use and up-to-date PHP wrapper for the M-Pesa Mozambique API.

Target version of M-Pesa API: **v1x**

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
4. Check Response

    All transactions return the `TransactionResponse` object. The object has the following public methods:

    1. `getCode()` - Returns the response code i.e. `INS-0`

    2. `getDescription()` - Returns the description.

    3. `getTransactionID()` - Returns the transaction ID.

    4. `getConversationID()` - Returns the conversation ID.

    5. `getTransactionStatus()` - Returns the transaction status. Only populated when calling the `query()` transaction.

    6. `getResponse()` - Returns the full response JSON object as received from M-Pesa servers. Good for debugging any issues or undocumented behaviors of the M-Pesa API.

In a typical scenario, code to check for successful transactions should be as follows:

```php
$c2b = $transaction->c2b(...);

if($c2b->getCode() === 'INS-0') {
    // Transaction Successful, Do something here
}
```

## Testing
This repo provides Unit Tests to validate the objects and their interaction with M-Pesa.

To run tests, 
1. Open the `phpunit.xml` file and add the require credentials/parameters as supplied by M-Pesa.
2. Run `phpunit` 
3. Check the handset for USSD prompts to approve test transactions.

All tests use 1MT as the test amount.


## License

This library is release under the MIT License. See LICENSE file for details.
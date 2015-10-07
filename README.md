# Omnipay: Secupay

**Secupay driver for the Omnipay PHP payment processing library**

[![Build Status](https://travis-ci.org/sauladam/omnipay-secupay.svg?branch=master)](https://travis-ci.org/sauladam/omnipay-secupay)
[![Total Downloads](https://poser.pugx.org/sauladam/omnipay-secupay/downloads.png)](https://packagist.org/packages/sauladam/omnipay-secupay)

This is non-official Omnipay-driver for the German payment gateway provider [Secupay](https://www.secupay.ag/).
In order to use it the Omnipay-Framework is required.

[Omnipay](https://github.com/omnipay/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Secupay support for Omnipay.

## Installation

This package is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "sauladam/omnipay-secupay": "dev-master"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

The following gateways are provided by this package:

* Secupay_LS (Direct Debit)
* Secupay_KK (Credit Card)

For general usage instructions, please see the main [Omnipay](https://github.com/omnipay/omnipay)
repository.

### Setting up the gateway
This is quite simple because the API only needs an API key.

```php
require 'vendor/autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('Secupay_LS'); // or 'Secupay_KK' for credit card
$gateway->setApiKey('yourApiKey');

// Testmode is on by default, so you want to switch it off for production.
$gateway->setTestMode(false);
```
You can also specify if you want to use the dist system. This is some kind of test environment that won't mess with your actual Secupay account. The transactions won't appear in your Secupay backend. It's recommended for "initial development" to make sure to not screw anything up. **This has nothing to do with the test-mode** and if you don't quite understand the purpose, just leave it as it is, otherwise you can switch it on an off as you like.

```php
$gateway->setUseDistSystem(true); // false by default
```

### Initializing a payment
Since Secupay will have to do some risk checking, you should provide it a reasonable amount of data about the payment amount, the person paying it and the shipping destination:

```php
$response = $gateway->authorize([
    'amount'          => 1234, // the payment amount in the smallest currency unit
    'currency'        => 'EUR', // the currency ISO code
    'urlSuccess'      => 'https://example.com/success',
    'urlFailure'      => 'https://example.com/failure',
    'urlPush'         => 'https://example.com/push', // optional
    'customerDetails' => [
        'email'   => 'user@example.com', // optional
        'ip'      '123.456.789.123', // optional
        'address' => [
            'firstName'   => 'Billing Firstname',
            'lastName'    => 'Billing Lastname',
            'street'      => 'Billing Street',
            'houseNumber' => '4a',
            'zip'         => '12345',
            'city'        => 'Billing City',
            'country'     => 'DE',
        ],
    ],
    'deliveryAddress' => [
        'firstName'   => 'Delivery Firstname',
        'lastName'    => 'Delivery Lastname',
        'street'      => 'Delivery Street',
        'houseNumber' => '4a',
        'zip'         => '12345',
        'city'        => 'Delivery City',
        'country'     => 'DE',
    ],
])->send();

if ($response->isSuccessful()) {
    // this is the hash for subsequent API interactions
    $transactionReference = $response->getTransactionReference(); 
    
    // this is the id that references the actual payment 
    // and that you'll see in the Secupay backend
    $transactionId = $response->getTransactionId();
    
    // this is the url you should redirect the customer 
    // to or display within an iframe
    $iframeUrl = $response->getIframeUrl();
} else {
    echo 'Something went wrong: ' . $response->getMessage();
}
```
The iframeUrl points to a (secure) page where the customer can enter her Credit Card / Debit Card data. You probably don't want that kind of data to ever touch your own server, so Secupay provides a form with the necessary fields, encryption and checks. You can redirect the customer to that URL or embed it as an iframe and display it to them - either is fine.

After the customer has filled out and submitted the form, Secupay will redirect them to what you've specified as you *urlSuccess* in the authorize request. Ideally that URL should contain some kind of payment identifier or some reference to your previously stored `$transactionReference`, because you now need it to check the status of this transaction:

### Check the status
```php
$response = $gateway->status([
    'hash' => $transactionReference,
])->send();
```
The status now must be *accepted*, so check for that:
```php
if($response->getTransactionStatus() == 'accepted')
{
    // Everything was fine, the payment went through, the order is now ready to ship.
}
```

And that's pretty much all there is to it. If you want to void / cancel that transaction, you can do so:

### Void a transaction
```php
$response = $gateway->void([
    'hash' => $transactionReference,
])->send();

if($response->isSuccessful())
{
    // The transaction has now become void.
}
```

## Support

For more usage examples please have a look at the tests of this package. Also have a look at the [Secupay API Documentation](https://github.com/secupay/doc-flex-api) for further details.

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/sauladam/omnipay-secupay/issues),
or better yet, fork the library and submit a pull request.

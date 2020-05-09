# Mercado Pago SDK for PHP

[![Latest Stable Version](https://poser.pugx.org/mercadopago/dx-php/v/stable)](https://packagist.org/packages/mercadopago/dx-php)
[![Total Downloads](https://poser.pugx.org/mercadopago/dx-php/downloads)](https://packagist.org/packages/mercadopago/dx-php)
[![License](https://poser.pugx.org/mercadopago/dx-php/license)](https://packagist.org/packages/mercadopago/dx-php)

This library provides developers with a simple set of bindings to the Mercado Pago API.

### PHP Versions Supported:

The SDK supports PHP 5.6, 7.1 or major

### Installation 

#### Using Composer

1. Download [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos) if not already installed
2. Go to your project directory and run on the command line
`composer require "mercadopago/dx-php:2.0.0"` for PHP7 or `composer require "mercadopago/dx-php:1.8.1"` for PHP5.6.
See the latest version (here)[https://github.com/mercadopago/dx-php/releases].

3. This how your directory structure would look like.
4. Thats all, you have Mercado Pago SDK installed.

![installation-demo](img/ezgif-2-f98e8701825e.gif)

### Quick Start 

1. You have to require the library from your Composer vendor folder.

  ```php
  require __DIR__  . '/vendor/autoload.php';
  ```

2. Setup your credentials

    ```php
    MercadoPago\SDK::setAccessToken("YOUR_ACCESS_TOKEN");      // On Production
    MercadoPago\SDK::setAccessToken("YOUR_TEST_ACCESS_TOKEN"); // On Sandbox
    ```
    
3. Using resource objects.

  You can interact with all the resources available in the public API, to this each resource is represented by classes according to the following diagram:
  
  ![sdk resource structure](https://user-images.githubusercontent.com/864790/34393059-9acad058-eb2e-11e7-9987-494eaf19d109.png)
  
  **Sample**
  
```php
  <?php
  
    require __DIR__  . '/vendor/autoload.php';

    MercadoPago\SDK::setAccessToken("YOUR_ACCESS_TOKEN");

    $payment = new MercadoPago\Payment();

    $payment->transaction_amount = 141;
    $payment->token = "YOUR_CARD_TOKEN";
    $payment->description = "Ergonomic Silk Shirt";
    $payment->installments = 1;
    $payment->payment_method_id = "visa";
    $payment->payer = array(
      "email" => "larue.nienow@hotmail.com"
    );
 
    echo $payment->status;
    
  ?>
```

### Included code samples
There are a number of included code examples in the `/samples` directory. To use them, you first have to navigate to said directory and run `composer install`. After that you can execute each sample through the command line, for example `php suscriptions/plan-create.php`.

\* Keep in mind you have to supply an access token for the samples to work.

### Support 

Write us at [developers.mercadopago.com](https://developers.mercadopago.com)

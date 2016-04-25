# EBAY-SDK-TRADING

[![Build Status](https://travis-ci.org/davidtsadler/ebay-sdk-trading.svg?branch=master)](https://travis-ci.org/davidtsadler/ebay-sdk-trading)

This project enables PHP developers to use the [eBay API](https://go.developer.ebay.com/developers/ebay/documentation-tools/) in their PHP code, and build software using the [Trading](http://developer.ebay.com/DevZone/guides/ebayfeatures/index.html) service. You can get started by [installing the SDK via Composer](http://devbay.net/sdk/guides/installation/) and by following the [Getting Started Guide](http://devbay.net/sdk/guides/getting-started/).

## Features

  - Compatible with PHP 5.3.9 or greater.
  - Easy to install with [Composer](http://getcomposer.org/).
  - Compliant with [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md), [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md) and [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md).

## Resources

  - [User Guides](http://devbay.net/sdk/guides/) - Getting started guide and in-depth information.
  - [SDK Versions](http://devbay.net/sdk/guides/versions/) - A complete list of each SDK, and the API version they support.
  - [Sample Project](https://github.com/davidtsadler/ebay-sdk-examples) - Provides several examples of using the SDK.
  - [Google Group](https://groups.google.com/forum/#!forum/ebay-sdk-php) - Join for support with the SDK.
  - [@devbaydotnet](https://twitter.com/devbaydotnet) - Follow on Twitter for announcements of releases, important changes and so on.

## Requirements

  - PHP 5.3.3 or greater with the following extensions:
      - cURL
      - libxml
  - 64 bit version of PHP recommended as there are some [issues when using the SDK with 32 bit](http://devbay.net/sdk/guides/requirements/#issues).
  - SSL enabled on the cURL extension so that https requests can be made.

## Installation

The SDK can be installed with [Composer](http://getcomposer.org/).

  1. Install Composer.

     ```
     curl -sS https://getcomposer.org/installer | php
     ```

  1. Install the SDK.

     ```
     php composer.phar require dts/ebay-sdk-trading
     ```

  1. Require Composer's autoloader by adding the following line to your code.

     ```php
     require 'vendor/autoload.php';
     ```

## Example

### Get the official eBay time

```php
<?php

require 'vendor/autoload.php';

use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;

// Create the service object.
$service = new Services\TradingService(array(
    'apiVersion' => '863',
    'siteId' => Constants\SiteIds::US
));

// Create the request object.
$request = new Types\GeteBayOfficialTimeRequestType();

$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = 'YOUR_PRODUCTION_USER_TOKEN_APPLICATION_KEY';

// Send the request to the service operation.
$response = $service->geteBayOfficialTime($request);

// Output the result of calling the service operation.
printf("The official eBay time is: %s\n", $response->Timestamp->format('H:i (\G\M\T) \o\n l jS Y'));
```

## Project Goals

  - Be well maintained.
  - Be [well documented](http://devbay.net/sdk/guides/).
  - Be [well tested](https://github.com/davidtsadler/ebay-sdk-trading/tree/master/test/DTS/eBaySDK/Trading).
  - Be well supported with [working examples](https://github.com/davidtsadler/ebay-sdk-examples/blob/master/trading/README.md).

## Project Maturity

This is a personal project that has been developed by me, [David T. Sadler](http://twitter.com/davidtsadler). I decided to create this project to make up for the lack of an official SDK for PHP. It is in no way endorsed, sponsored or maintained by eBay.

As this is a brand new project you should expect frequent releases until it reaches the stable `1.0.0` target. I will endeavour to keep changes to a minimum between each release and any changes will be [documented](https://github.com/davidtsadler/ebay-sdk-trading/blob/master/CHANGELOG.md).

## License

Licensed under the [Apache Public License 2.0](http://www.apache.org/licenses/LICENSE-2.0.html).

Copyright 2014 [David T. Sadler](http://twitter.com/davidtsadler)

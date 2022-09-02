<h2 align="center">
    Wasiliana Laravel Sdk
</h2>

<p align="center">

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

</p>

## Introduction

This package is built for Laravel developers to easen interaction with Wasiliana Rest Api.

## :smiley: Installation

```bash
composer require wasiliana/laravel-sdk
```

## :gear: Configuration

You can use `php artisan wasiliana:install` to copy the distribution configuration file to your app's config directory:

```bash
php artisan wasiliana:install
```

This will copy `wasiliana.php` settings file in your config directory.

Settings available in config file published.

```bash
return [
    'sms' => [
        'service_1' => [
            'name' => 'test',
            'from' => env('SMS_SERVICE_1_SENDER_ID', 'WASILIANA'),
            'key' => env('SMS_SERVICE_1_API_KEY', null)
        ],
    ],
    'airtime' => [
        'service_1' => [
            'name' => 'testAirtime',
            'key' => env('AIRTIME_SERVICE_1_API_KEY', null)
        ],
    ]
];
```

In a scenario where you have more than one service; the structure will appear as below.

```bash
return [
    'sms' => [
        'service_1' => [
            'name' => 'testSms',
            'from' => env('SERVICE_1_SENDER_ID', 'WASILIANA'),
            'key' => env('SERVICE_1_API_KEY', null)
        ],
        'service_2' => [
            'name' => 'testSms2',
            'from' => env('SERVICE_2_SENDER_ID', 'WASILIANA'),
            'key' => env('SERVICE_2_API_KEY', null)
        ]
    ],
    'airtime' => [
        'service_1' => [
            'name' => 'testAirtime',
            'key' => env('AIRTIME_SERVICE_1_API_KEY', null)
        ]
    ]
];
```

## :fire: Usage

### 1. Sms

Import the Sms Facade at the top;

```php
use Wasiliana\LaravelSdk\Facades\Sms;
```

#### Example 1: request
Using default service configured in wasiliana config file

```php
$response = Sms::to(['2547XXXXXYYY', '2547XXXXXZZZ']) //use an array for multiple recipients
    ->message('This cold...Mayoooo!!!') // your message
    ->send(); // fire request

// OR

$response = Sms::send('2547XXXXXYYY', 'This cold...Mayoooo!!!'); //compose message, add recipients and send
```

#### Example 2: request 
Using a different service configured in wasiliana config file

```php
$response = Sms::to('2547XXXXXYYY')
    ->message('This a test dispatch.')
    ->service('service_2')
    ->send();

// OR

$response = Sms::service('service_2')->send(['2547XXXXXYYY', '2547XXXXXZZZ'], 'This a send test using a different service.'); // for multiple recipients use an array
```

#### Example 3: Request
Defing a custom message_uid prefix

```php
$response = Sms::to(['2547XXXXXYYY', '2547XXXXXZZZ'])
    ->message('This cold...Mayoooo!!!')
    ->prefix('notification') // custom message_uid prefix 
    ->send();

// OR

$response = Sms::send('2547XXXXXYYY', 'This cold...Mayoooo!!!', 'notification');
```

#### Example 4: Response
After every request a response in array format is returned

```php
// success response
// a confirmation from Wasiliana that the request has been received.
Array
(
    [status] => success
    [data] => Successfully Dispatched the sms to process
    [message_uid] => conversation_id_20220831154811
)

// error response
Array
(
    [status] => error
    [message] => Error in the data provided
    [data] => Array
        (
            [0] => The message field is required.
        )

)
```

The confirmation of whether the message was delivered successfully, to a number, or not is delivered to the callback configured in your account.

### 2. Airtime

Import the Sms Facade at the top;

```php
use Wasiliana\LaravelSdk\Facades\Airtime;
```

#### Example 1: Request
Using default service configured in wasiliana config file

```php
$response = Airtime::amount(10)->phone('0720XXXYYY')->send();
```

#### Example 2: Request
Send same amount of airtime to multiple numbers at once

```php
$response = Airtime::amount(10)->->phone(['0723XXXYYY', '0711YYYXXX'])->send();
```

#### Example 3: Request
Using a different service configured in wasiliana config file

```php
$response = Airtime::amount(10)->phone('0720XXXYYY')->service('service_2')->send();
```

#### Example 4: Response
Success and error responses retirned

```php

// success response
Array
(
    [status] => success
    [message] => Ksh. 10 has been toped up sucessfuly
)

// error response
Array
(
    [status] => error
    [message] => Error in the data provided
    [data] => Array
        (
            [0] => The phone field is required.
        )

)

Array
(
    [status] => error
    [message] => You do not have sufficient airtime
    [data] => 
)
```

## Environment variables
You can update your `.env` to have the SENDER_ID and API_KEY values instead of having them in the config file;

```dotenv
SMS_SERVICE_1_SENDER_ID=<Sender_Id>
SMS_SERVICE_1_API_KEY=<Api_Key>

AIRTIME_SERVICE_1_API_KEY=<Api_Key>
```
**NOTE:** You don't have to define a SENDER_ID in the `.env` when you are using the shared `WASILIANA` SENDER_ID

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/wasiliana/laravel-sdk.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/wasiliana/laravel-sdk.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/wasiliana/laravel-sdk/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield
[link-packagist]: https://packagist.org/packages/wasiliana/laravel-sdk
[link-downloads]: https://packagist.org/packages/wasiliana/laravel-sdk
[link-travis]: https://travis-ci.org/wasiliana/laravel-sdk
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/wasiliana
[link-contributors]: ../../contributors

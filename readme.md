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
$ composer require wasiliana/laravel-sdk
```

## :gear: Configuration

You can use `php artisan wasiliana:install` to copy the distribution configuration file to your app's config directory:

```bash
php artisan wasiliana:install
```

Settings available in config file published.

```bash
return [
    'sms' => [
        'service_1' => [
            'name' => 'test',
            'from' => env('SERVICE_1_SENDER_ID', 'WASILIANA'),
            'key' => env('SERVICE_1_API_KEY', null)
        ]
    ]
];
```

In a scenario where you have more than one service; the structure will appear as below.

```bash
return [
    'sms' => [
        'service_1' => [
            'name' => 'test',
            'from' => env('SERVICE_1_SENDER_ID', 'WASILIANA'),
            'key' => env('SERVICE_1_API_KEY', null)
        ],
        'service_2' => [
            'name' => 'test2',
            'from' => env('SERVICE_2_SENDER_ID', 'WASILIANA'),
            'key' => env('SERVICE_2_API_KEY', null)
        ]
    ]
];
```

## :fire: Usage

In your code use it like this.

```php

# import
use Wasiliana\LaravelSdk\Facades\Sms;


# Example 1; using default service configured in wasiliana config file
$response = Sms::to(['2547XXXXXYYY', '2547XXXXXZZZ']) //use an array for multiple recipients
    ->message('This cold...Mayoooo!!!') // your message
    ->dispatch(); // fire request

# OR

$response = Sms::send('2547XXXXXYYY', 'This cold...Mayoooo!!!'); //compose message, add recipients and send


# Example 2; using a different service configured in wasiliana config file
$response = Sms::to('2547XXXXXYYY')
    ->message('This a test dispatch.')
    ->service('service_2')
    ->dispatch();

# OR

$response = Sms::service('service_2')->send(['2547XXXXXYYY', '2547XXXXXZZZ'], 'This a send test using a different service.'); // for multiple recipients use an array

# Example 3; custom message_uid prefix
$response = Sms::to(['2547XXXXXYYY', '2547XXXXXZZZ'])
    ->message('This cold...Mayoooo!!!')
    ->prefix('notification') // custom message_uid prefix 
    ->dispatch();

# OR

$response = Sms::send('2547XXXXXYYY', 'This cold...Mayoooo!!!', 'notification');

```


You can update your `.env` to have the SENDER_ID API_KEY values instead of having them in the config file;

```dotenv
SERVICE_1_SENDER_ID=<Sender_Id>
SERVICE_1_API_KEY=<Api_Key>
```

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

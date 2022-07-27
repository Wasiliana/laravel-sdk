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

This package provides access to Wasiliana REST Api and simplifies calling of different methods.

## :smiley: Installation

```bash
$ composer require wasiliana/laravel-sdk
```

## :fire: Usage

In your code use it like this.

```php
# import
use Wasiliana\LaravelSdk\Facades\Sms;


# Option 1
$response = Sms::message('This cold...Mayoooo!!!')
    ->from('SENDER123') // if this value is not set, default "WASILIANA" is used as sender (optional)
    ->to('Number 1') // use an array for multiple recipients
    ->prefix('test') // used in generation of message_uid (optional)
    ->dispatch(); // fire request

# Option 2
$response = Sms::message('This cold...Mayoooo!!!')
    ->from('WASILIANA')
    ->to('254723384144')
    ->dispatch();

# Option 3
$response = Sms::message('This cold...Mayoooo!!!')
    ->to('254723384144')
    ->dispatch();

# Option 4
$response = Sms::send('WASILIANA', ['Number 1', 'Number 2'],'This cold...Mayoooo!!!', 'test');
```

***NB:*** If `from` and `prefix` values are not set, the default in config file will be used.

## :gear: Configuration

You can use `php artisan wasiliana:install` to copy the distribution configuration file to your app's config directory:

```bash
php artisan wasiliana:install
```

These are the settings available in config file published

```bash
return [
    'api' => [
        'key' => env('WASILIANA_API_KEY')
    ],
    'sms' => [
        'prefix' => 'conversation_id',
        'from' => env('WASILIANA_SENDER_ID', 'WASILIANA')
    ]
];
```

Update your `.env` file with the Api Key.\


```dotenv
WASILIANA_API_KEY=api_key
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

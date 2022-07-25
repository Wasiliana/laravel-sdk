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

:smiley: Installation
------------

```bash
$ composer require wasiliana/laravel-sdk
```

:fire: Usage
------------

In your code just use it like this.

```php
# import
use Wasiliana\LaravelSdk\Facades\Sms;


# In your Controller.
$response = Sms::message('This cold...Mayoooo!!!')
    ->from('SENDER123') // if this value is not set, default "WASILIANA" is used as sender
    ->to('Number 1') // use an array for multiple recipients
    ->prefix('test') // used in generation of message_uid
    ->send(); // fire request

#OR...
$response = Sms::send('WASILIANA', ['Number 1', 'Number 2'],'This cold...Mayoooo!!!', 'test');


```

:gear: Configuration
-------------

You can use `artisan vendor:publish` to copy the distribution configuration file to your app's config directory:

```bash
php artisan vendor:publish --provider="Wasiliana\LaravelSdk\LaravelSdkServiceProvider" --tag="wasiliana"
```

Then update `config/wasiliana.php` with your Api Key generated from the account dashboard. Alternatively, you can update your `.env` file with the following:

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

<?php

namespace Wasiliana\LaravelSdk\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelSdk extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-sdk';
    }
}

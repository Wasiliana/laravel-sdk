<?php

namespace Wasiliana\LaravelSdk\Facades;

use Illuminate\Support\Facades\Facade;

class Otp extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'ws_otp';
    }
}

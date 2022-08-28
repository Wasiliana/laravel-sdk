<?php

namespace Wasiliana\LaravelSdk\Traits;

use Illuminate\Support\Facades\Validator;

trait Validates
{
    protected  function  validateAirtime(array $payload)
    {
        return Validator::make(
            $payload,
            [
                'service'  => 'required|array',
                'service.name'  => 'required',
                'service.key'  => 'required',
                'amount'  => 'required|integer|min:5|max:1000',
                'phone'  => 'required',
            ],
            [
                'service.name.required' => 'Service name is required.',
                'service.key.required' => 'Service Api key is required.',
                'amount.min' => 'Airtime amount should not be less than 5.',
                'amount.max' => 'Airtime amount should not be greater than 1000.',
            ]
        );
    }
}

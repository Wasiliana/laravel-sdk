<?php

namespace Wasiliana\LaravelSdk\Traits;

use Illuminate\Support\Facades\Validator;

trait Validates
{
    protected function validateSms(array $data)
    {
        return Validator::make(
            $data,
            [
                'recipients' => [
                    function ($attribute, $value, $fail) {
                        if (!is_string($value) && !is_array($value)) {
                            $fail(':attribute data type is invalid.');
                        }
                    },
                ],
                'message' => 'required',
                'service'  => 'required|array|min:2',
                'service.name'  => 'required',
                'service.from'  => 'required',
                'service.key'  => 'required',
                'prefix'  => 'required',
                'isOtp'  => 'required|boolean',
            ],
            [
                'service.min' => 'The service array must have at least 2 items.',
                'service.name.required' => 'Service name is required.',
                'service.from.required' => 'Service "from" value is required.',
                'service.key.required' => 'Api key is required.'
            ]
        );
    }
    protected function validateAirtime(array $data)
    {
        return Validator::make(
            $data,
            [
                'service'  => 'required|array',
                'service.name'  => 'required',
                'service.key'  => 'required',
                'amount'  => 'required|integer|min:10',
                'phone'  => 'required',
            ],
            [
                'service.name.required' => 'Service name is required.',
                'service.key.required' => 'Service Api key is required.',
                'amount.min' => 'Airtime amount should not be less than 10.',
            ]
        );
    }
}

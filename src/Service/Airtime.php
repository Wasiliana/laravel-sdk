<?php

namespace Wasiliana\LaravelSdk\Service;

use Illuminate\Support\Arr;
use Wasiliana\LaravelSdk\Traits\HttpClient;
use Wasiliana\LaravelSdk\Traits\Validates;

use function PHPSTORM_META\map;

class Airtime
{
    use HttpClient, Validates;

    /**
     * @param string
     */
    private $service;

    /**
     * The airtime amount to send
     * 
     * @param int
     */
    private $amount;

    /**
     * The phone number
     * 
     * @param string
     */
    private $phone;

    public function __construct()
    {
        $this->service = config('wasiliana.airtime.service_1');
    }

    /**
     * Airtime amount to send
     */
    public function amount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Phone number to receive airtime
     */
    public function phone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Fire the request; the data needs to pass validation first to be used.
     */
    public function dispatch()
    {
        $validator = $this->validateAirtime(['service' => $this->service, 'amount' => $this->amount, 'phone' => $this->phone]);

        if ($validator->fails()) {
            return ['status' => 'error', 'data' => Arr::flatten($validator->errors()->getMessages())];
        }

        $payload = $this->payload($validator->validated());

        return $this->postRequest('airtime/request', $payload);
    }

    /**
     * 
     * Build  body of the http request
     */
    private function payload($data)
    {
        return [
            'key' => $data['service']['key'],
            'amount' => $data['amount'],
            'phone_number' => $data['phone']
        ];
    }
}

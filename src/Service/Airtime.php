<?php

namespace Wasiliana\LaravelSdk\Service;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Arr;
use Wasiliana\LaravelSdk\Traits\HttpClient;
use Wasiliana\LaravelSdk\Traits\Payload;
use Wasiliana\LaravelSdk\Traits\Validates;


class Airtime
{
    use HttpClient, Validates, Payload;

    /**
     * amount
     * 
     * @param int
     */
    private $amount;

    /**
     * phone number
     * 
     * @param string
     */
    private $phone;

    /**
     * service
     * 
     * @param string
     */
    private $service;


    /**
     * Set amount
     */
    public function amount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Set phone number
     */
    public function phone($phone)
    {
        $this->phone = $phone;
        return $this;
    }


    /**
     * Set service to use
     */
    public function service($service)
    {
        if (config()->has('wasiliana.airtime.' . $service)) {
            $this->service = config('wasiliana.airtime.' . $service);
        } else {
            $this->service = [];
        }
        return $this;
    }

    /**
     * Fire the request; the data needs to pass validation first to be used.
     */
    public function send($amount = null, $phone = null, string  $service = 'service_1')
    {
        $service = ($this->service && count($this->service)) > 0 ? null : $service;
        $this->set($amount, $phone, $service);

        $validator = $this->validateAirtime(['service' => $this->service, 'amount' => $this->amount, 'phone' => $this->phone]);

        if ($validator->fails()) {
            return ['status' => 'error', 'data' => Arr::flatten($validator->errors()->getMessages())];
        }

        $payload = $this->airtime($validator->validated());

        try {
            $response = $this->makeRequest2('airtime/request', $payload);

            return json_decode($response->getBody(), true);
        } catch (RequestException $exception) {
            return array_merge(['status' => 'error'], json_decode($exception->getResponse()->getBody(), true));
        }
    }

    /**
     * 
     * Call the set functions with values
     */
    private function set($amount, $phone, $service)
    {
        $map = [
            'amount' => 'amount',
            'phone' => 'phone',
            'service' => 'service'
        ];

        foreach ($map as $var => $method) {
            if (${$var}) {
                call_user_func([$this, $method], ${$var});
            }
        }
    }
}

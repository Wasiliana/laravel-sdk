<?php

namespace Wasiliana\LaravelSdk\Service;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Wasiliana\LaravelSdk\Traits\ConversationId;
use Wasiliana\LaravelSdk\Traits\HttpClient;

class Sms
{

    use HttpClient, ConversationId;

    /**
     * @param string|array
     */
    private $service;

    /**
     * @param string
     */
    private $from;

    /**
     * @param string|array
     */
    private $to;

    /**
     * @param string
     */
    private $message;

    /**
     * @param string
     */
    private $prefix;

    /**
     * @param bool
     */
    private $isOtp;

    public function __construct()
    {
        $this->service = config('wasiliana.sms.service_1');
        $this->from = 'WASILIANA';
        $this->to = null;
        $this->message = null;
        $this->prefix = 'conversation_id';
        $this->isOtp = false;
    }

    /**
     * 
     * At the very least, recipients and message should be available
     */
    private function validate(array $data)
    {
        return Validator::make(
            $data,
            [
                // 'service'  => 'filled',
                'service'  => 'required|array|min:2',
                'service.name'  => 'required',
                'service.from'  => 'required',
                'service.key'  => 'required',
                'recipients' => [
                    function ($attribute, $value, $fail) {
                        if (!is_string($value) && !is_array($value)) {
                            $fail(':attribute data type is invalid.');
                        }
                    },
                ],
                'message' => 'required',
            ],
            [
                'service.min' => 'The service array must have at least 2 items.',
                'service.name.required' => 'Service name is required.',
                'service.key.required' => 'Api key is required.'
            ]
        );
    }

    /**
     * 
     * Build  body of the http request
     */
    private function payload($sender, $to, $message, $key, $prefix = null, $isOtp)
    {
        return [
            'from' => $sender,
            'recipients' => is_array($to) ? $to : [$to],
            'message' => $message,
            'key' => $key,
            'message_uid' => $this->uniqueId($prefix),
            'is_otp' => $isOtp
        ];
    }

    /**
     * service name defined in wasiliana config file. Default is 'service_1'
     */
    public function service($service)
    {
        if (config()->has('wasiliana.sms.' . $service)) {
            $this->service = config('wasiliana.sms.' . $service);
        } else {
            $this->service = [];
        }
        return $this;
    }

    /**
     * Set the Sender ID or leave it blank to use default "WASILIANA"
     */
    // public function from($from)
    // {
    //     $this->from = $from;
    //     return $this;
    // }

    /**
     * Phone numbers to receive messsage. Can be string for one number or array for multiple
     */
    public function to($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * Message to send to recipients
     */
    public function message($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Set custom text that will form part of message_uid. Default is "conversation_id".
     */
    public function prefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }


    /**
     * Specify if it is an Otp request
     */
    public function isOtp($isOtp)
    {
        $this->isOtp = $isOtp;
        return $this;
    }

    /**
     * Fire the request
     */
    public function dispatch()
    {
        // $validator = $this->validate([
        //     'recipients' => $this->to,
        //     'message' => $this->message,
        // ]);
        // echo $this->service;exit;
        // print_r($this->service);exit;

        $validator = $this->validate([
            'service' => $this->service,
            'recipients' => $this->to,
            'message' => $this->message,
        ]);

        if ($validator->fails()) {
            return ['status' => 'error', 'data' => Arr::flatten($validator->errors()->getMessages())];
        }

        // $this->from = $this->service['from'];

        $payload = $this->payload($this->service['from'], $this->to, $this->message, $this->service['key'], $this->prefix, $this->isOtp);

        return $this->postRequest('sms/bulk/send/sms/request', $payload);
    }

    /**
     * Make request
     */
    public function send($to, string $message, string $prefix = 'conversation_id')
    {
        $validator = $this->validate([
            'service' => $this->service,
            'recipients' => $to,
            'message' => $message,
        ]);

        if ($validator->fails()) {
            return ['status' => 'error', 'data' => Arr::flatten($validator->errors()->getMessages())];
        }

        $payload = $this->payload($this->service['from'], $to, $message, $this->service['key'], $prefix, $this->isOtp);

        return $this->postRequest('sms/bulk/send/sms/request', $payload);
    }
}

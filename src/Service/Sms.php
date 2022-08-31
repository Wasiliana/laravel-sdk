<?php

namespace Wasiliana\LaravelSdk\Service;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Arr;
use Wasiliana\LaravelSdk\Traits\ConversationId;
use Wasiliana\LaravelSdk\Traits\HttpClient;
use Wasiliana\LaravelSdk\Traits\Payload;
use Wasiliana\LaravelSdk\Traits\Validates;

class Sms
{

    use HttpClient, ConversationId, Validates, Payload;

    /**
     * recipients
     * 
     * @param string|array
     */
    private $to;

    /**
     * message
     * 
     * @param string
     */
    private $message;

    /**
     * service to use
     * 
     * @param string
     */
    private $service;

    /**
     * prefix
     * 
     * @param string
     */
    private $prefix;

    /**
     * true or false
     * 
     * @param bool
     */
    private $isOtp = false;

    /**
     * Set recipients
     */
    public function to($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * Set message body
     */
    public function message($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Set service
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
     * Set prefix to be appended to message_uuid
     */
    public function prefix($prefix)
    {
        $this->prefix = $this->uniqueId($prefix);
        return $this;
    }


    /**
     * Set true or false
     */
    public function isOtp($isOtp)
    {
        $this->isOtp = $isOtp ?: false;
        return $this;
    }

    /**
     * Dispatch the request
     */
    public function send($to = null, string $message = null, string  $service = 'service_1', string $prefix = 'conversation_id')
    {
        $service = ($this->service && count($this->service)) > 0 ? null : $service;
        $prefix = $this->prefix ?: $prefix;

        $this->set($to, $message, $service, $prefix, $this->isOtp);

        $validator = $this->validateSms([
            'recipients' => $this->to,
            'message' => $this->message,
            'service' => $this->service,
            'prefix' => $this->prefix,
            'isOtp' => $this->isOtp
        ]);

        if ($validator->fails()) {
            return ['status' => 'error', 'data' => Arr::flatten($validator->errors()->getMessages())];
        }

        $payload = $this->sms($validator->validated());
      
        try {
            $response = $this->makeRequest('sms/bulk/send/sms/request', $payload);

            $body = json_decode($response->getBody(), true);

            if ((int)$response->getStatusCode() != 200) {
                return array_merge($body, ['message_uid' => $payload['message_uid']]);
            }

            return array_merge($body, ['message_uid' => $payload['message_uid']]);
        } catch (RequestException $exception) {
            return array_merge(['status' => 'error'], json_decode($exception->getResponse()->getBody(), true));
        }
    }

    /**
     * Call the set functions with values
     */
    private function set($to, $message, $service, $prefix, $isOtp)
    {
        $map = [
            'to' => 'to',
            'message' => 'message',
            'service' => 'service',
            'prefix' => 'prefix',
            'isOtp' => 'isOtp',
        ];

        foreach ($map as $var => $method) {
            if (${$var}) {
                call_user_func([$this, $method], ${$var});
            }
        }
    }
}

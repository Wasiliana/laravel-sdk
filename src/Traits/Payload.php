<?php

namespace Wasiliana\LaravelSdk\Traits;

trait Payload
{
    protected function sms(array $data)
    {
        return [
            'from' => $data['service']['from'],
            'recipients' => is_array($data['recipients']) ? $data['recipients'] : [$data['recipients']],
            'message' => $data['message'],
            'key' => $data['service']['key'],
            'message_uid' => $data['prefix'],
            'is_otp' => $data['isOtp']
        ];
    }
}

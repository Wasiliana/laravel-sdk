<?php

namespace Wasiliana\LaravelSdk\Service;

use Wasiliana\LaravelSdk\Traits\ConversationId;
use Wasiliana\LaravelSdk\Traits\HttpClient;

class Sms
{

    use HttpClient, ConversationId;

    public function __construct()
    {
    }

    private function checkRecipients($recipients)
    {
        $type = gettype($recipients);

        if ($type === 'string') {
            return [$recipients];
        } elseif ($type === 'array') {
            return $recipients;
        } else {
            return null;
        }
    }

    private function payload($recipients, $message)
    {
        return [
            'from' => config('wasiliana.sms.from'),
            'message_uid' => $this->uniqueId('outbox'),
            'recipients' => $recipients,
            'message' => $message
        ];
    }

    private function request($payload)
    {
        return $this->postRequest('sms/bulk/send/sms/request', $payload);
    }

    public function send($recipients, string $message)
    {
        $data = $this->checkRecipients($recipients);

        if ($data  == null) return 'Invalid recipients data.';

        $payload = $this->payload($data, $message);

        return $this->request($payload);
    }
}

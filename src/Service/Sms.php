<?php

namespace Wasiliana\LaravelSdk\Service;

use Wasiliana\LaravelSdk\Traits\ConversationId;
use Wasiliana\LaravelSdk\Traits\HttpClient;

class Sms
{

    use HttpClient, ConversationId;


    protected $recipients;

    protected $message;

    protected $prefix;

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

    private function payload($recipients, $message, $prefix = null)
    {
        return [
            'from' => config('wasiliana.sms.from'),
            'message_uid' => $prefix == null && $this->prefix == null ? $this->uniqueId() : call_user_func(function () use ($prefix) {
                if ($prefix != null) {
                    return $this->uniqueId($prefix);
                } else {
                    return $this->uniqueId($this->prefix);
                }
            }),
            'recipients' => $recipients,
            'message' => $message
        ];
    }

    private function request($payload)
    {
        return $this->postRequest('sms/bulk/send/sms/request', $payload);
    }

    public function recipients($recipients)
    {
        $this->recipients = $this->checkRecipients($recipients);
        return $this;
    }

    public function message($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Set custom text that will form part of message_uid. Default is "outbox".
     */
    public function prefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    public function send($recipients = null, $message = null,  $prefix = null)
    {
        if ($recipients != null) {
            $contacts = $this->recipients($recipients);
        } else {
            $contacts = $this->recipients;
        }

        if ($contacts  == null) return 'Invalid recipients data.';

        if ($message != null) {
            $msg = $message;
        } else {
            $msg = $this->message;
        }

        if ($msg == null) return 'Message is required.';

        $payload = $this->payload($this->recipients, $msg, $prefix);
        // print_r($payload);exit;

        return $this->request($payload);
    }
}

<?php

namespace Wasiliana\LaravelSdk\Service;

use Illuminate\Support\Arr;
use Wasiliana\LaravelSdk\Traits\ConversationId;
use Wasiliana\LaravelSdk\Traits\HttpClient;

class Sms
{

    use HttpClient, ConversationId;

    protected $from;

    protected $to;

    protected $message;

    protected $prefix;

    public function __construct()
    {
    }

    private function checkRecipients($recipients)
    {
        $type = gettype($recipients);

        if ($type === 'string') {
            return Arr::wrap($recipients);
        } elseif ($type === 'array') {
            return $recipients;
        } else {
            return null;
        }
    }

    private function payload($sender, $to, $message, $prefix = null)
    {
        return [
            'from' => $sender,
            'message_uid' => $prefix == null && $this->prefix == null ? $this->uniqueId() : call_user_func(function () use ($prefix) {
                if ($prefix != null) {
                    return $this->uniqueId($prefix);
                } else {
                    return $this->uniqueId($this->prefix);
                }
            }),
            'recipients' => $to,
            'message' => $message
        ];
    }

    /**
     * Set the Sender ID or leave it blank to use default "WASILIANA"
     */
    public function from($from)
    {
        $this->from = $from ? $from : 'WASILIANA';
        return $this;
    }

    /**
     * Phone numbers to receive messsage. Can be string for one number or array for multiple
     */
    public function to($to)
    {
        $this->to = $this->checkRecipients($to);
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
     * Set custom text that will form part of message_uid. Default is "outbox".
     */
    public function prefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * 
     * @param string|null        $from
     * @param string|array||null $to
     * @param string|null        $message
     * @param string|null        $prefix
     * 
     */
    public function send($from = null, $to = null, $message = null, $prefix = null)
    {
        if ($from != null) {
            $sender = $from;
        } else {
            $sender = $this->from;
        }

        if ($to != null) {
            $contacts = $this->checkRecipients($to);
        } else {
            $contacts = $this->to;
        }

        if ($contacts  == null) return 'Invalid recipients data.';

        if ($message != null) {
            $msg = $message;
        } else {
            $msg = $this->message;
        }

        if ($msg == null) return 'Message is required.';

        $payload = $this->payload($sender, $contacts, $msg, $prefix);

        return $this->postRequest('sms/bulk/send/sms/request', $payload);
    }
}

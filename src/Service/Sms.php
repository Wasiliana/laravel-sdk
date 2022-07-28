<?php

namespace Wasiliana\LaravelSdk\Service;


use Illuminate\Support\Facades\Validator;
use Wasiliana\LaravelSdk\Traits\ConversationId;
use Wasiliana\LaravelSdk\Traits\HttpClient;

class Sms
{

    use HttpClient, ConversationId;


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
        $this->from = config('wasiliana.sms.from');
        $this->to = null;
        $this->message = null;
        $this->prefix = config('wasiliana.sms.prefix');
        $this->isOtp = false;
    }

    /**
     * 
     * At the very least, recipients and message should be available
     */
    private function validate(array $data)
    {
        return Validator::make($data, [
            'recipients' => [
                function ($attribute, $value, $fail) {
                    if (!is_string($value) && !is_array($value)) {
                        $fail(':attribute data type is invalid.');
                    }
                },
            ],
            'message' => 'required',
        ]);
    }

    /**
     * 
     * Build  body of the http request
     */
    private function payload($sender, $to, $message, $prefix = null, $isOtp)
    {
        return [
            'from' => $sender,
            'message_uid' => $this->uniqueId($prefix),
            'recipients' => is_array($to) ? $to : [$to],
            'message' => $message,
            'is_otp' => $isOtp
        ];
    }

    /**
     * Set the Sender ID or leave it blank to use default "WASILIANA"
     */
    public function from($from)
    {
        $this->from = $from;
        return $this;
    }

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
        $validator = $this->validate([
            'recipients' => $this->to,
            'message' => $this->message,
        ]);

        if ($validator->fails()) {
            return $validator->errors()->getMessages();
        }

        $payload = $this->payload($this->from, $this->to, $this->message, $this->prefix, $this->isOtp);

        return $this->postRequest('sms/bulk/send/sms/request', $payload);
    }

    /**
     * Make request
     */
    public function send(string $from, $to, string $message, string $prefix = null)
    {
        $validator = $this->validate([
            'recipients' => $to,
            'message' => $message,
        ]);

        if ($validator->fails()) {
            return $validator->errors()->getMessages();
        }

        $payload = $this->payload($from, $this->to, $message, $prefix, $this->isOtp);

        return $this->postRequest('sms/bulk/send/sms/request', $payload);
    }
}

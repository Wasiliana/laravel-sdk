<?php

namespace Wasiliana\LaravelSdk\Service;

use Wasiliana\LaravelSdk\Traits\ConversationId;
use Wasiliana\LaravelSdk\Traits\HttpClient;

class Otp {

    use HttpClient, ConversationId;

    protected $from;

    protected $to;

    protected $message;

    protected $prefix;

    public function __construct()
    {
    }
}
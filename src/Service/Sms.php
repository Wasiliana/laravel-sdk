<?php

namespace Wasiliana\LaravelSdk\Service;

use Wasiliana\LaravelSdk\Traits\HttpClient;

class Sms
{

    use HttpClient;

    public function send($recipients, $message)
    {
    }

    private function validate($recipients)
    {
        $type = gettype($recipients);

        if ($type === 'string') {
        } elseif ($type === 'array') {
        } else {
        }
    }

    private function bundle()
    {
    }
}

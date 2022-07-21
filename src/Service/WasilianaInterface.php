<?php

namespace Wasiliana\LaravelSdk\Service;

interface WasilianaInterface {
    public function sms($uniqueId, $phone, $message);
}
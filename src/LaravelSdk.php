<?php

namespace Wasiliana\LaravelSdk;

use GuzzleHttp\ClientInterface;

class LaravelSdk
{

    private $client;

    public function __construct(ClientInterface $clientInterface)
    {
        $this->client = $clientInterface;
    }

    public function client()
    {
        return $this->client;
    }
}

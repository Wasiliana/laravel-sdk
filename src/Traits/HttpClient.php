<?php

namespace Wasiliana\LaravelSdk\Traits;

use Wasiliana\LaravelSdk\LaravelSdk;

trait HttpClient
{

    protected $sdk;

    public function __construct(LaravelSdk $sdk)
    {
        $this->sdk = $sdk;
    }

    private function postRequest($endpoint, $payload)
    {
        return $this->sdk->client()->request('POST', $endpoint, ['json' => $payload]);
    }
}

<?php

namespace Wasiliana\LaravelSdk\Traits;

use Wasiliana\LaravelSdk\Http\CoreClient;

trait HttpClient
{
    /**
     * @var Core
     */
    protected $coreClient;

    public function __construct(CoreClient $core)
    {
        $this->coreClient = $core;
    }

    private function makeRequest($endpoint, $payload, array $queryParams = [], string $method = 'POST')
    {
        return $this->coreClient->client()->request($method, $endpoint, [
            'headers' => [
                'apiKey' => $payload['key'],
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
            'query' => $queryParams
        ]);
    }
}

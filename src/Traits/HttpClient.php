<?php

namespace Wasiliana\LaravelSdk\Traits;

use GuzzleHttp\Client;
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
        return $this->coreClient
            ->client()
            ->request($method, $endpoint, [
                'headers' => [
                    'apiKey' => $payload['key'],
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
                'query' => $queryParams
            ]);
    }

    private function makeRequest2($endpoint, $payload, array $queryParams = [], string $method = 'POST')
    {
        return $this->coreClient
            ->useClient(new Client(['base_uri' => 'https://apiv2.wasiliana.io/api/v1/']))
            ->client()
            ->request($method, $endpoint, [
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

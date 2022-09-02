<?php

namespace Wasiliana\LaravelSdk\Http;

use GuzzleHttp\ClientInterface;

class CoreClient
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * CoreClient constructor.
     *
     * @param ClientInterface    $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Get the client.
     *
     * @return ClientInterface
     */
    public function client()
    {
        return $this->client;
    }

    /**
     * Switch the client instance.
     *
     * @param string|null $account
     *
     * @return self
     */
    public function useClient(ClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }
}

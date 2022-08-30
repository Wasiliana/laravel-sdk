<?php

namespace Wasiliana\LaravelSdk\Http;

use GuzzleHttp\ClientInterface;
use SmoDav\Mpesa\Auth\Authenticator;
use SmoDav\Mpesa\Contracts\CacheStore;
use SmoDav\Mpesa\Contracts\ConfigurationStore;
use SmoDav\Mpesa\Native\NativeCache;
use SmoDav\Mpesa\Native\NativeConfig;
use SmoDav\Mpesa\Repositories\ConfigurationRepository;

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

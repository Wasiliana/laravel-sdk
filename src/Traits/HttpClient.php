<?php

namespace Wasiliana\LaravelSdk\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\TooManyRedirectsException;

trait HttpClient
{

    private function postRequest($endpoint, $payload)
    {
        $client = new Client([
            'base_uri' => 'https://api.wasiliana.com/api/v1/developer/',
            'headers' => [
                'apiKey' => config('wasiliana.api.key'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ]);

        try {
            $response = $client->request('POST', $endpoint, ['json' => $payload]);

            if ((int)$response->getStatusCode() != 200) {
                return $response->getBody()->getContents();
            }

            return $response->getBody()->getContents();
        } catch (ClientException $clientexception) {
            return $clientexception->getMessage();
        } catch (ServerException $serverexception) {
            return $serverexception->getMessage();
        } catch (ConnectException $connectexception) {
            return $connectexception->getMessage();
        } catch (TooManyRedirectsException $toomanyredirectexception) {
            return $toomanyredirectexception->getMessage();
        }
    }
}

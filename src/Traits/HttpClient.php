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
                'apiKey' => $payload['key'],
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ]);

        try {
            $response = $client->request('POST', $endpoint, ['json' => $payload]);

            if ((int)$response->getStatusCode() != 200) {
                return json_decode($response->getBody(), true);
            }

            $body = json_decode($response->getBody(), true);

            return array_merge($body, ['message_uid' => $payload['message_uid']]);
        } catch (ClientException $clientexception) {
            return ['message' => $clientexception->getMessage(), 'code' => $clientexception->getCode()];
        } catch (ServerException $serverexception) {
            return ['message' => $serverexception->getMessage(), 'code' => $serverexception->getCode()];
        } catch (ConnectException $connectexception) {
            return ['message' => $connectexception->getMessage(), 'code' => $connectexception->getCode()];
        } catch (TooManyRedirectsException $toomanyredirectexception) {
            return ['message' => $toomanyredirectexception->getMessage(), 'code' => $toomanyredirectexception->getCode()];
        }
    }
}

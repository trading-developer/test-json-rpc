<?php

namespace App\Services\JsonRpc;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class JsonRpcClient
{
    const JSON_RPC_VERSION = '2.0';

    const METHOD_URI = 'api';

    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'headers' => ['Content-Type' => 'application/json'],
            'base_uri' => env('ACTIVITY_SERVICE_URL')
        ]);
    }

    public function send(string $method, array $params = []): array
    {
        try {
            $response = $this->client
                ->postAsync(self::METHOD_URI, [
                    RequestOptions::JSON => [
                        'jsonrpc' => self::JSON_RPC_VERSION,
                        'id' => time(),
                        'method' => $method,
                        'params' => $params
                    ]
                ])->wait()->getBody()->getContents();

            return \json_decode($response, true);
        } catch (\Exception $exception) {
            return [];
        }
    }
}

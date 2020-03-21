<?php

declare(strict_types=1);

namespace Sip\Psinder\E2E\Collection\Api;

use Sip\Psinder\E2E\Collection\Adopters;
use Sip\Psinder\E2E\Collection\Tokens;
use Fig\Http\Message\RequestMethodInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

final class ApiAdopters implements Adopters
{
    private ClientInterface $client;
    private Tokens $tokens;

    public function __construct(ClientInterface $client, Tokens $tokens)
    {
        $this->client = $client;
        $this->tokens = $tokens;
    }

    public function register(array $offer) : string
    {
        $request = new Request(
            RequestMethodInterface::METHOD_POST,
            '/adopters',
            [],
            \GuzzleHttp\json_encode($offer)
        );

        $response = $this->client->send($request);

        $payload = \GuzzleHttp\json_decode((string) $response->getBody(), true);

        return $payload['id'];
    }
}

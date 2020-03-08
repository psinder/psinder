<?php

declare(strict_types=1);

namespace Sip\Psinder\E2E\Collection\Api;

use Sip\Psinder\E2E\Collection\Tokens;
use function DI\value;
use Fig\Http\Message\RequestMethodInterface;
use Fig\Http\Message\StatusCodeInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Sip\Psinder\E2E\Collection\Offers;

final class ApiOffers implements Offers
{
    private const OFFERS_URL = '/offers';

    private ClientInterface $client;
    private Tokens $tokens;

    public function __construct(ClientInterface $client, Tokens $tokens)
    {
        $this->client = $client;
        $this->tokens = $tokens;
    }

    public function post(array $offer) : string
    {
        $request = new Request(
            RequestMethodInterface::METHOD_POST,
            self::OFFERS_URL,
            [
                'Authorization' => 'Bearer ' . $this->tokens->get($offer['shelterId'])->__toString()
            ],
            \GuzzleHttp\json_encode($offer)
        );

        $response = $this->client->send($request);

        $payload = \GuzzleHttp\json_decode((string) $response->getBody(), true);

        return $payload['id'];
    }

    public function list() : array
    {
        $request = new Request(
            RequestMethodInterface::METHOD_GET,
            self::OFFERS_URL
        );

        $response = $this->client->send($request);

        return \GuzzleHttp\json_decode((string) $response->getBody(), true);
    }

    public function get(string $id) : ?array
    {
        $request = new Request(
            RequestMethodInterface::METHOD_GET,
            sprintf('%s/%s', self::OFFERS_URL, $id)
        );

        $response = $this->client->send($request);

        if ($response->getStatusCode() === StatusCodeInterface::STATUS_NO_CONTENT) {
            return null;
        }

        return \GuzzleHttp\json_decode((string) $response->getBody(), true);
    }
}

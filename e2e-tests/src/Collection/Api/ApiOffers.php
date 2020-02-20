<?php

declare(strict_types=1);

namespace Sip\Psinder\E2E\Collection\Api;

use function DI\value;
use Fig\Http\Message\RequestMethodInterface;
use Fig\Http\Message\StatusCodeInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Sip\Psinder\E2E\Collection\Offers;

final class ApiOffers implements Offers
{
    private const OFFERS_URL = '/offers';

    /** @var ClientInterface */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function post(array $offer) : string
    {
        $request = new Request(
            RequestMethodInterface::METHOD_POST,
            self::OFFERS_URL,
            [],
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

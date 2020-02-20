<?php

declare(strict_types=1);

namespace Sip\Psinder\E2E\Collection\Api;

use function DI\value;
use Fig\Http\Message\RequestMethodInterface;
use Fig\Http\Message\StatusCodeInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestFactoryInterface;
use Sip\Psinder\E2E\Collection\Offers;
use Sip\Psinder\E2E\Collection\Shelters;
use Sip\Psinder\SharedKernel\UI\Http\RequestBuilder;
use Sip\Psinder\SharedKernel\UI\Http\RequestBuilderFactory;

final class ApiShelters implements Shelters
{
    /** @var ClientInterface */
    private $client;

    /** @var RequestBuilderFactory */
    private $requestBuilderFactory;

    public function __construct(ClientInterface $client, RequestBuilderFactory $requestBuilderFactory)
    {
        $this->client = $client;
        $this->requestBuilderFactory = $requestBuilderFactory;
    }

    public function create(array $shelter) : string
    {
        $request = $this->requestBuilderFactory->create()
            ->post()
            ->url('/register')
            ->jsonBodyArray(
                array_merge(
                    [
                        'type' => 'shelter'
                    ],
                    $shelter
                )
            )
            ->create();

        $response = $this->client->send($request);

        $payload = \GuzzleHttp\json_decode((string) $response->getBody(), true);

        return $payload['id'];
    }
}

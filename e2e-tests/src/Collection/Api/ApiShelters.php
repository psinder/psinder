<?php

declare(strict_types=1);

namespace Sip\Psinder\E2E\Collection\Api;

use GuzzleHttp\ClientInterface;
use Sip\Psinder\E2E\Collection\Shelters;
use Sip\Psinder\SharedKernel\UI\Http\RequestBuilderFactory;

final class ApiShelters implements Shelters
{
    private ClientInterface $client;
    private RequestBuilderFactory $requestBuilderFactory;

    public function __construct(ClientInterface $client, RequestBuilderFactory $requestBuilderFactory)
    {
        $this->client = $client;
        $this->requestBuilderFactory = $requestBuilderFactory;
    }

    public function create(array $shelter) : string
    {
        $request = $this->requestBuilderFactory->create()
            ->post()
            ->url('/register/shelter')
            ->jsonBodyArray(
                [
                    'email' => $shelter['email'],
                    'password' => $shelter['password'],
                    'name' => $shelter['name'],
                    'addressStreet' => $shelter['address_street'],
                    'addressNumber' => $shelter['address_number'],
                    'addressPostalCode' => $shelter['address_postal'],
                    'addressCity' => $shelter['address_city'],
                ]
            )
            ->create();

        $response = $this->client->send($request);

        $payload = \GuzzleHttp\json_decode((string) $response->getBody(), true);

        return $payload['id'];
    }
}

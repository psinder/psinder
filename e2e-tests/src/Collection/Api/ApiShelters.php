<?php

declare(strict_types=1);

namespace Sip\Psinder\E2E\Collection\Api;

use GuzzleHttp\ClientInterface;
use Sip\Psinder\E2E\Collection\Shelters;
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
                [
                    'type' => 'shelter',
                    'email' => $shelter['email'],
                    'password' => $shelter['password'],
                    'context' => [
                        'name' => $shelter['name'],
                        'address_street' => $shelter['address_street'],
                        'address_number' => $shelter['address_number'],
                        'address_postal' => $shelter['address_postal'],
                        'address_city' => $shelter['address_city'],
                    ]
                ]
            )
            ->create();

//        | name | email | password | address_street | address_number | address_postal | address_city |

        $response = $this->client->send($request);

        $payload = \GuzzleHttp\json_decode((string) $response->getBody(), true);

        return $payload['id'];
    }
}

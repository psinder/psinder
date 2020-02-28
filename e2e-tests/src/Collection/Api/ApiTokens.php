<?php

declare(strict_types = 1);

namespace Sip\Psinder\E2E\Collection\Api;

use GuzzleHttp\ClientInterface;
use Sip\Psinder\E2E\Collection\Tokens;
use Sip\Psinder\SharedKernel\UI\Http\RequestBuilderFactory;

final class ApiTokens implements Tokens
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

    public function retrieve( string $email, string $password ): ?string
    {
        $request = $this->requestBuilderFactory->create()
            ->post()
            ->url('/login')
            ->jsonBodyArray(
                [
                    'email' => $email,
                    'password' => $password
                ]
            )
            ->create();

        $response = $this->client->send($request);

        return $response->getHeader( 'Authentication' )[0] ?? null;
    }
}

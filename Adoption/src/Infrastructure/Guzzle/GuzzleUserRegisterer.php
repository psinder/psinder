<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Guzzle;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Sip\Psinder\Adoption\Application\Command\UserRegisterer;
use Sip\Psinder\SharedKernel\UI\Http\RequestBuilderFactory;

final class GuzzleUserRegisterer implements UserRegisterer
{
    public string $id;
    /** @var string[] */
    public array $roles;
    public string $email;
    public string $password;

    private ClientInterface $client;
    private RequestBuilderFactory $requestBuilderFactory;
    private LoggerInterface $logger;

    public function __construct(
        ClientInterface $client,
        RequestBuilderFactory $requestBuilderFactory,
        LoggerInterface $logger
    ) {
        $this->client                = $client;
        $this->requestBuilderFactory = $requestBuilderFactory;
        $this->logger                = $logger;
    }

    /** @param string[] $roles */
    public function register(string $id, string $email, string $plainPassword, array $roles): void
    {
        $request = $this->requestBuilderFactory->create()
            ->post()
            ->url('/register')
            ->jsonBodyArray([
                'id' => $id,
                'email' => $email,
                'password' => $plainPassword,
                'roles' => $roles,
            ])
            ->create();

        try {
            $response = $this->client->send($request);
        } catch (GuzzleException $e) {
            $this->logger->error('Failed to register user', ['exception' => $e]);
        }
    }
}

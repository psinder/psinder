<?php

declare(strict_types = 1);

namespace Sip\Psinder\E2E\Collection\Api;

use GuzzleHttp\ClientInterface;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Token;
use Sip\Psinder\E2E\Collection\Tokens;
use Sip\Psinder\SharedKernel\UI\Http\RequestBuilderFactory;

final class ApiTokens implements Tokens
{
    private ClientInterface $client;
    private RequestBuilderFactory $requestBuilderFactory;
    /** @var string[] */
    private array $tokens;
    private ?Token $currentToken;

    public function __construct(ClientInterface $client, RequestBuilderFactory $requestBuilderFactory)
    {
        $this->client = $client;
        $this->requestBuilderFactory = $requestBuilderFactory;
    }

    public function obtain( string $email, string $password ): ?Token
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

        $headerString = $response->getHeader( 'Authorization' )[0] ?? null;

        $token = explode(' ', $headerString)[1] ?? null;
        $token = (new Parser())->parse($token);
        $this->tokens[$token->getClaim('jti')] = $token;

        $this->currentToken = $token;

        return $token;
    }

    public function get(string $id): ?Token
    {
        $token = $this->tokens[$id] ?? null;

        if ($token) {
            $this->currentToken = $token;
        }

        return $token;
    }

    public function current(): Token
    {
        if ($this->currentToken === null) {
            throw new \RuntimeException('No current token');
        }

        return $this->currentToken;
    }
}

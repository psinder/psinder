<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\UI\Http;

use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use function Safe\json_encode as safe_json_encode;

class RequestBuilder
{
    private RequestFactoryInterface $factory;

    private StreamFactoryInterface $streamFactory;
    private UriFactoryInterface $uriFactory;

    private string $method;
    private UriInterface $url;
    private string $body = '';
    private ?string $token = null;

    public function __construct(
        RequestFactoryInterface $factory,
        StreamFactoryInterface $streamFactory,
        UriFactoryInterface $uriFactory
    ) {
        $this->factory       = $factory;
        $this->streamFactory = $streamFactory;
        $this->uriFactory    = $uriFactory;

        $this->method = RequestMethodInterface::METHOD_GET;
        $this->url    = $this->uriFactory->createUri('/');
    }

    public function method(string $method) : self
    {
        $this->method = $method;

        return $this;
    }

    public function post() : self
    {
        return $this->method(RequestMethodInterface::METHOD_POST);
    }

    public function as(string $token) : self {
        $this->token = $token;

        return $this;
    }

    public function url(string $url) : self
    {
        $this->url = $this->uriFactory->createUri($url);

        return $this;
    }

    /**
     * @param mixed[] $body
     */
    public function jsonBodyArray(array $body) : self
    {
        $this->body = safe_json_encode($body);

        return $this;
    }

    public function create() : RequestInterface
    {
        $request = $this->factory->createRequest(
            $this->method,
            $this->url
        );

        if ($this->token) {
            $request = $request->withHeader('Authorization', 'Bearer ' . $this->token);
        }

        return $request
            ->withBody($this->streamFactory->createStream($this->body));
    }
}

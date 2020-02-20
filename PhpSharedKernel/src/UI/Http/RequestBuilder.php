<?php

declare(strict_types = 1);

namespace Sip\Psinder\SharedKernel\UI\Http;

use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

class RequestBuilder
{
    /** @var RequestFactoryInterface */
    private $factory;

    /** @var string */
    private $method;

    /** @var UriInterface */
    private $url;

    /** @var false|string */
    private $body;

    /** @var StreamFactoryInterface */
    private $streamFactory;

    /** @var UriFactoryInterface */
    private $uriFactory;

    public function __construct(
        RequestFactoryInterface $factory,
        StreamFactoryInterface $streamFactory,
        UriFactoryInterface $uriFactory
    ) {
        $this->factory = $factory;
        $this->streamFactory = $streamFactory;
        $this->uriFactory = $uriFactory;

        $this->method = RequestMethodInterface::METHOD_GET;
        $this->url = $this->uriFactory->createUri('/');
    }

    public function method(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function post(): self
    {
        return $this->method(RequestMethodInterface::METHOD_POST);
    }

    public function url(string $url): self
    {
        $this->url = $this->uriFactory->createUri($url);

        return $this;
    }

    public function jsonBodyArray(array $body): self
    {
        $this->body = json_encode($body);

        return $this;
    }

    public function create(): RequestInterface
    {
        $request = $this->factory->createRequest(
            $this->method,
            $this->url
        );

        return $request
            ->withBody($this->streamFactory->createStream(
                $this->body
            ));
    }
}

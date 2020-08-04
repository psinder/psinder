<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\UI\Http;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

final class RequestBuilderFactory
{
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;
    private UriFactoryInterface $uriFactory;
    private ServerRequestFactoryInterface $serverRequestFactory;

    public function __construct(
        RequestFactoryInterface $requestFactory,
        ServerRequestFactoryInterface $serverRequestFactory,
        StreamFactoryInterface $streamFactory,
        UriFactoryInterface $uriFactory
    ) {
        $this->requestFactory       = $requestFactory;
        $this->streamFactory        = $streamFactory;
        $this->uriFactory           = $uriFactory;
        $this->serverRequestFactory = $serverRequestFactory;
    }

    public function create(): RequestBuilder
    {
        return new RequestBuilder(
            $this->requestFactory,
            $this->streamFactory,
            $this->uriFactory,
        );
    }

    public function createServerRequestBuilder(): ServerRequestBuilder
    {
        return new ServerRequestBuilder(
            $this->serverRequestFactory,
            $this->streamFactory,
            $this->uriFactory,
        );
    }
}

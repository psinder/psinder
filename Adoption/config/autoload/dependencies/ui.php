<?php

declare(strict_types=1);

use Lcobucci\Clock\Clock;
use Psr\Container\ContainerInterface;
use Sip\Psinder\Adoption\UI\Http\Shelter\PostOfferRequestHandler;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;
use Sip\Psinder\SharedKernel\Infrastructure\Serializer\Serializer;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\AuthenticationMiddleware;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\JsonDeserializeMiddleware;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\JsonDeserializeToSpecifiedDTOMiddlewareFactory;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\RequestPayloadTargetDTOResolver;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\RouteResultRequestPayloadTargetDTOResolver;

return [
    'dependencies' => [
        'factories'  => [
            PostOfferRequestHandler::class => static function (ContainerInterface $c) : PostOfferRequestHandler {
                return new PostOfferRequestHandler(
                    $c->get(CommandBus::class)
                );
            },
            JsonDeserializeMiddleware::class => static function (ContainerInterface $c) {
                return new JsonDeserializeMiddleware(
                    $c->get(Serializer::class),
                    $c->get(RequestPayloadTargetDTOResolver::class)
                );
            },
            AuthenticationMiddleware::class => static function (ContainerInterface $c) {
                return new AuthenticationMiddleware(
                    $c->get(Clock::class),
                    'psinder'
                );
            },
            RouteResultRequestPayloadTargetDTOResolver::class => static function () {
                return new RouteResultRequestPayloadTargetDTOResolver();
            },
            JsonDeserializeToSpecifiedDTOMiddlewareFactory::class => static function (ContainerInterface $c) {
                return new JsonDeserializeToSpecifiedDTOMiddlewareFactory($c->get(Serializer::class),);
            },
        ],
    ],
];

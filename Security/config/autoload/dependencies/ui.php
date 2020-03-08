<?php

declare(strict_types=1);

use Lcobucci\Clock\Clock;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Psr\Container\ContainerInterface;
use Sip\Psinder\Adoption\UI\Http\Handler\Shelter\PostOfferRequestHandler;
use Sip\Psinder\Security\Presentation\Http\UserTokenFactory;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;
use Sip\Psinder\SharedKernel\Infrastructure\Serializer\Serializer;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\JsonDeserializeMiddleware;
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
            RouteResultRequestPayloadTargetDTOResolver::class => static function () {
                return new RouteResultRequestPayloadTargetDTOResolver();
            },
            UserTokenFactory::class => static function (ContainerInterface $c) {
                return new UserTokenFactory(
                    new Key(getenv('JWT_KEY')),
                    $c->get(Clock::class),
                    new Builder(),
                    'psinder'
                );
            },
        ],
    ],
];

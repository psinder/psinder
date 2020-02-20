<?php

declare(strict_types=1);

namespace Sip\Psinder\E2E\Container\Api;

use DI;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Sip\Psinder\E2E\Collection\Api\ApiOffers;
use Sip\Psinder\E2E\Collection\Offers;
use Sip\Psinder\E2E\Container\ContainerFactory;
use Sip\Psinder\SharedKernel\UI\Http\RequestBuilderFactory;

final class ApiContainerFactory extends ContainerFactory
{
    protected static function definitions() : array
    {
        return array_merge(
            [
                LoggerInterface::class => DI\factory(function (ContainerInterface $container) {
                    return new Logger('e2e', [
                        new StreamHandler(__DIR__ . '/../../../var/logs/e2e.log')
                    ]);
                }),
                'guzzle.stack' => DI\factory(function (ContainerInterface $container) {
                    $stack = HandlerStack::create();

                    $log = Middleware::log(
                        $container->get(LoggerInterface::class),
                        new MessageFormatter(MessageFormatter::DEBUG)
                    );

                    $stack->push($log);

                    return $stack;
                }),
            ],
            ApiAppClientContainerFactory::definitions(),
            ApiOfferContainerFactory::definitions(),
            ApShelterContainerFactory::definitions(),
            [
                RequestBuilderFactory::class => DI\factory(function (ContainerInterface $container) {
                    return new RequestBuilderFactory(
                        new Psr17Factory(),
                        new Psr17Factory(),
                        new Psr17Factory(),
                        new Psr17Factory()
                    );
                }),
            ]
        );
    }
}

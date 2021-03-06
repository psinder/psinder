<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Laminas\Diactoros\RequestFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\StreamFactory;
use Laminas\Diactoros\UriFactory;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Lcobucci\Clock\SystemClock;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Roave\PsrContainerDoctrine\ConnectionFactory;
use Roave\PsrContainerDoctrine\EntityManagerFactory;
use Sip\Psinder\Adoption\Infrastructure\Guzzle\GuzzleUserRegisterer;
use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryShelters;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\CommandBus\SymfonyMessengerCommandBus;
use Sip\Psinder\SharedKernel\Infrastructure\EventPublisher\SymfonyMessengerEventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\LoggingErrorListenerDelegatorFactory;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\MigrationsConfigurationFactory;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\ORM\ORMTransactionManager;
use Sip\Psinder\SharedKernel\Infrastructure\QueryBus\SymfonyMessengerQueryBus;
use Sip\Psinder\SharedKernel\Infrastructure\Serializer\SymfonySerializer\SymfonySerializer;
use Sip\Psinder\SharedKernel\UI\Http\RequestBuilderFactory;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DataUriNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializerComponent;

return [
    'dependencies' => [
        'delegators' => [
            ErrorHandler::class => [
                LoggingErrorListenerDelegatorFactory::class
            ]
        ],

        'factories'  => [
            SystemClock::class => static function (ContainerInterface $container) {
                return new SystemClock();
            },
            SymfonySerializer::class => static function (ContainerInterface $container) {
                return new SymfonySerializer(
                    $container->get(SymfonySerializerComponent::class),
                    'json'
                );
            },
            SymfonySerializerComponent::class => static function (ContainerInterface $container) {
                return new SymfonySerializerComponent(
                    [
                        new ObjectNormalizer(),
                        new DateTimeNormalizer(),
                        new DataUriNormalizer(),
                        new JsonSerializableNormalizer(),
                        new ArrayDenormalizer(),
                    ],
                    [new JsonEncoder()]
                );
            },
            InMemoryShelters::class => static function (ContainerInterface $container) {
                return new InMemoryShelters($container->get(EventPublisher::class));
            },
            SymfonyMessengerCommandBus::class => static function (ContainerInterface $c) {
                return new SymfonyMessengerCommandBus($c->get('messenger.command.bus'));
            },
            SymfonyMessengerQueryBus::class => static function (ContainerInterface $c) {
                return new SymfonyMessengerQueryBus($c->get('messenger.query.bus'));
            },
            SymfonyMessengerEventPublisher::class => static function (ContainerInterface $c) {
                return new SymfonyMessengerEventPublisher($c->get('messenger.event.bus'));
            },
            'doctrine.entity_manager.orm_default' => EntityManagerFactory::class,
            'doctrine.connection.orm_default' => ConnectionFactory::class,
            'doctrine.migrations.orm_default' => MigrationsConfigurationFactory::class,
            RequestBuilderFactory::class => static function (ContainerInterface $container) {
                return new RequestBuilderFactory(
                    new RequestFactory(),
                    new ServerRequestFactory(),
                    new StreamFactory(),
                    new UriFactory()
                );
            },
            ORMTransactionManager::class => static function(ContainerInterface $container) {
                return new ORMTransactionManager($container->get(EntityManagerInterface::class));
            },
            GuzzleUserRegisterer::class => static function(ContainerInterface $container): GuzzleUserRegisterer {
                return new GuzzleUserRegisterer(
                    // TODO: Introduce internal client
                    new Client([
                        'base_uri' => 'http://security-web'
                    ]),
                    $container->get(RequestBuilderFactory::class),
                    $container->get(LoggerInterface::class)
                );
            },
        ],
    ],
];

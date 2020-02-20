<?php

declare(strict_types=1);

use Bunny\Client;
use Laminas\Diactoros\RequestFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\StreamFactory;
use Laminas\Diactoros\UriFactory;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Roave\PsrContainerDoctrine\ConnectionFactory;
use Roave\PsrContainerDoctrine\EntityManagerFactory;
use Sip\Psinder\Adoption\Infrastructure\AMQP\BunnyConsumerCommandFactory;
use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryOffers;
use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryShelters;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\AMQP\BunnyConsumerCommand;
use Sip\Psinder\SharedKernel\Infrastructure\AMQP\BunnyDeclareCommand;
use Sip\Psinder\SharedKernel\Infrastructure\CommandBus\SymfonyMessengerCommandBus;
use Sip\Psinder\SharedKernel\Infrastructure\EventPublisher\SymfonyMessengerEventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\LoggingErrorListenerDelegatorFactory;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\MigrationsConfigurationFactory;
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
            InMemoryOffers::class => static function (ContainerInterface $container) {
                return new InMemoryOffers($container->get(EventPublisher::class));
            },
            Logger::class => static function (ContainerInterface $c) {
                return new Logger(
                    'main',
                    [new StreamHandler(getcwd() . '/var/logs/main.log')]
                );
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
            Client::class => static function () {
                return new Client([
                    'host'      => getenv('RABBITMQ_HOST'),
                    'user'      => getenv('RABBITMQ_USER'),
                    'password'  => getenv('RABBITMQ_PASS'),
                ]);
            },
            BunnyDeclareCommand::class => static function (ContainerInterface $container) {
                return new BunnyDeclareCommand(
                    $container->get(Client::class),
                    $container->get(LoggerInterface::class),
                    [
                        'queues' => [
                            [
                                'name' => 'adoption.register',
                                'exchange' => 'events',
                                'routingKey' => 'security.user_registered'
                            ]
                        ]
                    ]
                );
            },
            BunnyConsumerCommand::class => BunnyConsumerCommandFactory::class,
            RequestBuilderFactory::class => static function () {
                return new RequestBuilderFactory(
                    new RequestFactory(),
                    new ServerRequestFactory(),
                    new StreamFactory(),
                    new UriFactory()
                );
            },
        ],
    ],

    'console' => [
        'commands' => [
            BunnyConsumerCommand::class,
            BunnyDeclareCommand::class
        ]
    ],
];

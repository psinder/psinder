<?php

declare(strict_types=1);

use Bunny\AbstractClient;
use Bunny\Client;
use ContainerInteropDoctrine\ConnectionFactory;
use ContainerInteropDoctrine\EntityManagerFactory;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Sip\Psinder\SharedKernel\Infrastructure\AMQP\BunnyDeclareCommand;
use Sip\Psinder\SharedKernel\Infrastructure\AMQP\BunnyEventHandler;
use Sip\Psinder\SharedKernel\Infrastructure\EventPublisher\SymfonyMessengerEventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\LoggingErrorListenerDelegatorFactory;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\MigrationsConfigurationFactory;
use Sip\Psinder\SharedKernel\Infrastructure\Serializer\SymfonySerializer\PayloadableEventNormalizer;
use Sip\Psinder\SharedKernel\Infrastructure\Serializer\SymfonySerializer\SymfonySerializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DataUriNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Mezzio\Authentication\Session\PhpSession;
use Mezzio\Authentication\Session\PhpSessionFactory;

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
                    $container->get(Serializer::class),
                    'json'
                );
            },
            Serializer::class => static function (ContainerInterface $container) {
                return new Serializer(
                    [
                        new JsonSerializableNormalizer(),
                        new PayloadableEventNormalizer(),
                        new ObjectNormalizer(),
                        new DateTimeNormalizer(),
                        new DataUriNormalizer(),
                        new ArrayDenormalizer(),
                    ],
                    [new JsonEncoder()]
                );
            },
            Logger::class => static function (ContainerInterface $c) {
                return new Logger(
                    'main',
                    [new StreamHandler(getcwd() . '/var/logs/main.log')]
                );
            },
            SymfonyMessengerEventPublisher::class => static function (ContainerInterface $c) {
                return new SymfonyMessengerEventPublisher($c->get('messenger.event.bus'));
            },
            'doctrine.entity_manager.orm_default' => EntityManagerFactory::class,
            'doctrine.connection.default' => ConnectionFactory::class,
            'doctrine.migrations.orm_default' => MigrationsConfigurationFactory::class,
            PhpSession::class => PhpSessionFactory::class,
            Client::class => static function (ContainerInterface $container) {
                return new Client([
                    'host'      => getenv('RABBITMQ_HOST'),
                    'user'      => getenv('RABBITMQ_USER'),
                    'password'  => getenv('RABBITMQ_PASS'), // The default password is guest
                ]);
            },
            BunnyEventHandler::class => static function (ContainerInterface $container) {
                return new BunnyEventHandler(
                    $container->get(AbstractClient::class),
                    $container->get(\Sip\Psinder\SharedKernel\Infrastructure\Serializer\Serializer::class),
                    'events',
                    'security',
                    new CamelCaseToSnakeCaseNameConverter()
                );
            },
            BunnyDeclareCommand::class => static function (ContainerInterface $container) {
                return new BunnyDeclareCommand(
                    $container->get(AbstractClient::class),
                    $container->get(LoggerInterface::class),
                    [
                        'exchanges' => [
                            [
                                'name' => 'events',
                                'type' => 'topic',
                            ]
                        ]
                    ]
                );
            },
        ],
    ],

    'console' => [
        'commands' => [
            BunnyDeclareCommand::class
        ]
    ]
];

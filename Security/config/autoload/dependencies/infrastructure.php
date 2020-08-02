<?php

declare(strict_types=1);

use Bunny\Client;
use ContainerInteropDoctrine\ConnectionFactory;
use ContainerInteropDoctrine\EntityManagerFactory;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Lcobucci\Clock\SystemClock;
use Mezzio\Authentication\Session\PhpSession;
use Mezzio\Authentication\Session\PhpSessionFactory;
use Psr\Container\ContainerInterface;
use Sip\Psinder\SharedKernel\Infrastructure\EventPublisher\SymfonyMessengerEventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\LoggingErrorListenerDelegatorFactory;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\MigrationsConfigurationFactory;
use Sip\Psinder\SharedKernel\Infrastructure\Serializer\SymfonySerializer\PayloadableEventNormalizer;
use Sip\Psinder\SharedKernel\Infrastructure\Serializer\SymfonySerializer\SymfonySerializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DataUriNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

return [
    'dependencies' => [
        'delegators' => [
            ErrorHandler::class => [
                LoggingErrorListenerDelegatorFactory::class
            ]
        ],

        'factories'  => [
            SystemClock::class => static function () {
                return new SystemClock();
            },
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
        ],
    ],
];

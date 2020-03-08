<?php

declare(strict_types=1);

use Bunny\AbstractClient;
use Bunny\Client;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Sip\Psinder\SharedKernel\Infrastructure\Serializer\Serializer;
use Sip\Psinder\SharedKernel\Infrastructure\Serializer\SymfonySerializer\SymfonySerializer;
use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Authentication\OAuth2\OAuth2Adapter;
use Mezzio\Authentication\Session\PhpSession;

return [
    'dependencies' => [
        'aliases' => [
            Serializer::class => SymfonySerializer::class,
            LoggerInterface::class => Logger::class,
            AuthenticationInterface::class => PhpSession::class,
            EntityManagerInterface::class => 'doctrine.entity_manager.orm_default',
            Connection::class => 'doctrine.connection.default',
            AbstractClient::class => Client::class
        ],
    ],
];

<?php

declare(strict_types=1);

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Sip\Psinder\SharedKernel\Infrastructure\Serializer\Serializer;
use Sip\Psinder\SharedKernel\Infrastructure\Serializer\SymfonySerializer\SymfonySerializer;

return [
    'dependencies' => [
        'aliases' => [
            Serializer::class => SymfonySerializer::class,
            LoggerInterface::class => Logger::class,
            EntityManagerInterface::class => 'doctrine.entity_manager.orm_default',
            Connection::class => 'doctrine.connection.orm_default',
        ],
    ],
];

<?php

declare(strict_types=1);

use Doctrine\DBAL\Driver\PDOPgSql\Driver;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Sip\Psinder\Security\Infrastructure\Persistence\DBAL\Types\EmailType;
use Sip\Psinder\Security\Infrastructure\Persistence\DBAL\Types\User\EncodedPasswordType;
use Sip\Psinder\Security\Infrastructure\Persistence\DBAL\Types\User\RolesType;
use Sip\Psinder\Security\Infrastructure\Persistence\DBAL\Types\User\UserIdType;

return [
    'doctrine' => [
        'configuration' => [
            'orm_default' => [],
        ],
        'connection' => [
            'orm_default' => [
                'driver_class' => Driver::class,
                'params' => [
                    'dbname' => getenv('SECURITY_DB_NAME'),
                    'user' => getenv('SECURITY_DB_USER'),
                    'password' => getenv('SECURITY_DB_PASS'),
                    'host' => getenv('SECURITY_DB_HOST'),
                ],
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => XmlDriver::class,
                'cache' => 'array',
                'paths' => [
                    getcwd() . '/src/Infrastructure/Persistence/ORM/Mapping',
                ],
            ],
        ],
        'entity_manager' => [
            'orm_default' => [],
        ],
        'types' => [
            UserIdType::name() => UserIdType::class,
            RolesType::name() => RolesType::class,
            EncodedPasswordType::name() => EncodedPasswordType::class,
            EmailType::name() => EmailType::class
        ],
        'migrations' => [
            'orm_default' => [
                'directory' => 'db/migrations',
                'name'      => 'Psinder Security Migrations',
                'namespace' => 'DoctrineMigrations',
                'table'     => 'security_migrations',
            ],
        ],
    ],
];

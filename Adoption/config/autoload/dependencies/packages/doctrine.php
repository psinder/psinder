<?php

declare(strict_types=1);

use Doctrine\DBAL\Driver\PDOPgSql\Driver;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Adopter\AdopterIdType;
use Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Adopter\AdopterNameType;
use Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\ContactFormsType;
use Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Offer\ApplicationIdType;
use Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Offer\OfferIdType;
use Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Pet\PetIdType;
use Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Pet\PetNameType;
use Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Pet\PetSexType;
use Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Pet\PetTypeType;
use Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Shelter\ShelterIdType;
use Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Types\Shelter\ShelterNameType;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types\BirthdateType;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\DBAL\Types\GenderType;

return [
    'doctrine' => [
        'configuration' => [
            'orm_default' => [],
        ],
        'connection' => [
            'orm_default' => [
                'driver_class' => Driver::class,
                'params' => [
                    'dbname' => getenv('ADOPTION_DB_NAME'),
                    'user' => getenv('ADOPTION_DB_USER'),
                    'password' => getenv('ADOPTION_DB_PASS'),
                    'host' => getenv('ADOPTION_DB_HOST'),
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
            ShelterIdType::name() => ShelterIdType::class,
            ShelterNameType::name() => ShelterNameType::class,
            ContactFormsType::name() => ContactFormsType::class,
            PetIdType::name() => PetIdType::class,
            PetNameType::name() => PetNameType::class,
            PetSexType::name() => PetSexType::class,
            PetTypeType::name() => PetTypeType::class,
            BirthdateType::name() => BirthdateType::class,
            OfferIdType::name() => OfferIdType::class,
            ApplicationIdType::name() => ApplicationIdType::class,
            AdopterIdType::name() => AdopterIdType::class,
            AdopterNameType::name() => AdopterNameType::class,
            GenderType::name() => GenderType::class
        ],
        'migrations' => [
            'orm_default' => [
                'directory' => 'db/migrations',
                'name'      => 'Psinder Adoption Migrations',
                'namespace' => 'DoctrineMigrations',
                'table'     => 'doctrine_migration_versions',
            ],
        ],
    ],
];

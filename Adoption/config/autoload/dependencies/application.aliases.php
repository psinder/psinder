<?php

declare(strict_types=1);

use Lcobucci\Clock\Clock;
use Lcobucci\Clock\SystemClock;
use Sip\Psinder\Adoption\Application\Command\UserRegisterer;
use Sip\Psinder\Adoption\Application\Query\Shelter\OfferDetailsRepository;
use Sip\Psinder\Adoption\Infrastructure\Guzzle\GuzzleUserRegisterer;
use Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Read\Shelter\DBALOfferDetailsRepository;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;
use Sip\Psinder\SharedKernel\Application\Command\TransactionManager;
use Sip\Psinder\SharedKernel\Application\Query\QueryBus;
use Sip\Psinder\SharedKernel\Infrastructure\CommandBus\SymfonyMessengerCommandBus;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\ORM\ORMTransactionManager;
use Sip\Psinder\SharedKernel\Infrastructure\QueryBus\SymfonyMessengerQueryBus;

return [
    'dependencies' => [
        'aliases' => [
            CommandBus::class => SymfonyMessengerCommandBus::class,
            QueryBus::class => SymfonyMessengerQueryBus::class,
            OfferDetailsRepository::class => DBALOfferDetailsRepository::class,
            Clock::class => SystemClock::class,
            TransactionManager::class => ORMTransactionManager::class,
            UserRegisterer::class => GuzzleUserRegisterer::class
        ],
    ],
];

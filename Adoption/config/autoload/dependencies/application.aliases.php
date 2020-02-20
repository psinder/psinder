<?php

declare(strict_types=1);

use Sip\Psinder\Adoption\Application\Query\Shelter\OfferDetailsRepository;
use Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Read\Shelter\DBALOfferDetailsRepository;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;
use Sip\Psinder\SharedKernel\Application\Query\QueryBus;
use Sip\Psinder\SharedKernel\Infrastructure\CommandBus\SymfonyMessengerCommandBus;
use Sip\Psinder\SharedKernel\Infrastructure\QueryBus\SymfonyMessengerQueryBus;

return [
    'dependencies' => [
        'aliases' => [
            CommandBus::class => SymfonyMessengerCommandBus::class,
            QueryBus::class => SymfonyMessengerQueryBus::class,
            OfferDetailsRepository::class => DBALOfferDetailsRepository::class,
        ],
    ],
];

<?php

declare(strict_types=1);

use Sip\Psinder\Adoption\Application\Query\Shelter\OfferDetailsRepository;
use Sip\Psinder\Adoption\Infrastructure\Persistence\DBAL\Read\Shelter\DBALOfferDetailsRepository;
use Sip\Psinder\Security\Application\PasswordHasher;
use Sip\Psinder\Security\Infrastructure\PlainPasswordHasher;
use Sip\Psinder\Security\Infrastructure\Sha256PasswordHasher;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;
use Sip\Psinder\SharedKernel\Application\Query\QueryBus;
use Sip\Psinder\SharedKernel\Infrastructure\CommandBus\SymfonyMessengerCommandBus;
use Sip\Psinder\SharedKernel\Infrastructure\QueryBus\SymfonyMessengerQueryBus;

return [
    'dependencies' => [
        'aliases' => [
            PasswordHasher::class => Sha256PasswordHasher::class
        ],
    ],
];

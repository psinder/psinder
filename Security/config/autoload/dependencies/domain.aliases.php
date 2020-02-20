<?php

declare(strict_types=1);

use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Domain\Shelter\Shelters;
use Sip\Psinder\Adoption\Infrastructure\Persistence\ORM\ORMOffers;
use Sip\Psinder\Adoption\Infrastructure\Persistence\ORM\ORMShelters;
use Sip\Psinder\Security\Domain\User\Users;
use Sip\Psinder\Security\Infrastructure\Persistence\ORM\ORMUsers;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\EventPublisher\SymfonyMessengerEventPublisher;

return [
    'dependencies' => [
        'aliases' => [
            EventPublisher::class => SymfonyMessengerEventPublisher::class,
            Users::class => ORMUsers::class
        ],
    ],
];

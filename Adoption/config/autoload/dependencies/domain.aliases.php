<?php

declare(strict_types=1);

use Sip\Psinder\Adoption\Application\Command\UserRegisterer;
use Sip\Psinder\Adoption\Domain\Adopter\Adopters;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Domain\Shelter\Shelters;
use Sip\Psinder\Adoption\Domain\Transfer\Transfers;
use Sip\Psinder\Adoption\Infrastructure\Guzzle\GuzzleUserRegisterer;
use Sip\Psinder\Adoption\Infrastructure\Persistence\ORM\ORMAdopters;
use Sip\Psinder\Adoption\Infrastructure\Persistence\ORM\ORMOffers;
use Sip\Psinder\Adoption\Infrastructure\Persistence\ORM\ORMShelters;
use Sip\Psinder\Adoption\Infrastructure\Persistence\ORM\ORMTransfers;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\EventPublisher\SymfonyMessengerEventPublisher;

return [
    'dependencies' => [
        'aliases' => [
            Shelters::class => ORMShelters::class,
            Offers::class => ORMOffers::class,
            Adopters::class => ORMAdopters::class,
            Transfers::class => ORMTransfers::class,
            EventPublisher::class => SymfonyMessengerEventPublisher::class,
            UserRegisterer::class => GuzzleUserRegisterer::class
        ],
    ],
];

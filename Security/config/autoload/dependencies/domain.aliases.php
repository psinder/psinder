<?php

declare(strict_types=1);

use Sip\Psinder\Security\Application\AdoptionRegistrator;
use Sip\Psinder\Security\Domain\User\Users;
use Sip\Psinder\Security\Infrastructure\Guzzle\GuzzleAdoptionRegistrator;
use Sip\Psinder\Security\Infrastructure\Persistence\ORM\ORMUsers;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\EventPublisher\SymfonyMessengerEventPublisher;

return [
    'dependencies' => [
        'aliases' => [
            EventPublisher::class => SymfonyMessengerEventPublisher::class,
            Users::class => ORMUsers::class,
        ],
    ],
];

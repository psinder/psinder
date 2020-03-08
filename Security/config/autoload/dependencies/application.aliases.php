<?php

declare(strict_types=1);

use Lcobucci\Clock\Clock;
use Lcobucci\Clock\SystemClock;
use Sip\Psinder\Security\Application\PasswordHasher;
use Sip\Psinder\Security\Infrastructure\Sha256PasswordHasher;

return [
    'dependencies' => [
        'aliases' => [
            PasswordHasher::class => Sha256PasswordHasher::class,
            Clock::class => SystemClock::class,
        ],
    ],
];

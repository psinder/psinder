<?php

declare(strict_types=1);

namespace App;

use Sip\Psinder\Security\Application\RegisterAdopterOnUserRegistered;
use Sip\Psinder\Security\Domain\User\UserRegistered;

return [
    'messenger' => [
        'default_bus'        => 'messenger.event.bus',
        'buses'              => [
            'messenger.event.bus'   => [
                'allows_no_handler' => true,
                'handlers'   => [],
                'middleware' => [
                    'messenger.event.middleware.sender',
                    'messenger.event.middleware.handler'
                ],
                'routes'     => [],
            ],
        ],
    ],
];

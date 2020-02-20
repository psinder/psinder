<?php

declare(strict_types=1);

namespace App;

use Sip\Psinder\Security\Domain\User\UserRegistered;
use Sip\Psinder\SharedKernel\Infrastructure\AMQP\BunnyEventHandler;

return [
    'messenger' => [
        'default_bus'        => 'messenger.event.bus',
        'buses'              => [
            'messenger.event.bus'   => [
                'allows_no_handler' => true,
                'handlers'   => [
                    UserRegistered::class => [BunnyEventHandler::class]
                ],
                'middleware' => [
                    'messenger.event.middleware.sender',
                    'messenger.event.middleware.handler'
                ],
                'routes'     => [],
            ],
        ],
    ],
];

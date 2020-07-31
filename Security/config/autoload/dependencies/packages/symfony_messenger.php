<?php

declare(strict_types=1);

namespace App;

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

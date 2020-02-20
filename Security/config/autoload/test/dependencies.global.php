<?php

declare(strict_types=1);

use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\InterceptingEventPublisher;

return [
    'dependencies' => [
        'invokables' => [],
        'factories'  => [
            InterceptingEventPublisher::class => static function () {
                return new InterceptingEventPublisher();
            },
        ],
        'aliases' => [
            EventPublisher::class => InterceptingEventPublisher::class,
        ],
    ],
];

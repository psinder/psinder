<?php

declare(strict_types=1);

use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\InterceptingEventPublisher;


return [
    'dependencies' => [
        'factories'  => array_merge(
            [
                InterceptingEventPublisher::class => static function () {
                    return new InterceptingEventPublisher();
                },
            ],
            $GLOBALS['TEST_FACTORY_OVERRIDES']
        ),
        'shared' => [
            EventPublisher::class => true,
        ],
        'aliases' => array_merge(
            [
                EventPublisher::class => InterceptingEventPublisher::class,
            ],
            $GLOBALS['TEST_ALIAS_OVERRIDES']
        )
    ],
];

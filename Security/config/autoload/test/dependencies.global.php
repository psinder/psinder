<?php

declare(strict_types=1);

use Monolog\Logger;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\InterceptingEventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\Logging\TestLoggerFactory;


return [
    'dependencies' => [
        'factories'  => array_merge(
            [
                InterceptingEventPublisher::class => static function () {
                    return new InterceptingEventPublisher();
                },
                Logger::class => static function () {
                    $path = __DIR__ . '/../../../var/logs/test.log';
                    return (new TestLoggerFactory())($path);
                }
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

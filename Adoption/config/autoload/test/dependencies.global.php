<?php

declare(strict_types=1);

use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\InterceptingEventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\Logging\LoggerFactory;
use Sip\Psinder\SharedKernel\Infrastructure\Logging\TestLoggerFactory;

return [
    'dependencies' => [
        'factories'  => array_merge(
            [
                InterceptingEventPublisher::class => static function () {
                    return new InterceptingEventPublisher();
                },
                TestLoggerFactory::class => static function () : TestLoggerFactory {
                    return new TestLoggerFactory(__DIR__ . '/../../../var/logs/test.log');
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
                LoggerFactory::class => TestLoggerFactory::class,
            ],
            $GLOBALS['TEST_ALIAS_OVERRIDES']
        )
    ],
];

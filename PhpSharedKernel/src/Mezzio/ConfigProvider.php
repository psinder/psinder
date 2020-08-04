<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Mezzio;

use Laminas\ServiceManager\Proxy\LazyServiceFactory;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Sip\Psinder\SharedKernel\Infrastructure\Logging\LoggerFactory;
use Sip\Psinder\SharedKernel\Infrastructure\Logging\LogstashLoggerFactory;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\ORM\PSR3LoggingSQLLogger;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\ExecutionContext;

final class ConfigProvider
{
    private string $appName;

    public function __construct(string $appName)
    {
        $this->appName = $appName;
    }

    /** @return mixed[] */
    public function __invoke() : array
    {
        return [
            'dependencies' => [
                'aliases' => [
                    LoggerFactory::class => LogstashLoggerFactory::class,
                ],
                'factories'  => [
                    ExecutionContext::class =>  fn() => new ExecutionContext($this->appName),
                    Logger::class => static function (ContainerInterface $c) {
                        return $c->get(LoggerFactory::class)('main');
                    },
                ],
                'shared' => [ExecutionContext::class => true],
                'lazy_services' => [
                    'class_map' => [
                        PSR3LoggingSQLLogger::class => PSR3LoggingSQLLogger::class,
                    ],
                ],
                'delegators' => [
                    PSR3LoggingSQLLogger::class => [
                        LazyServiceFactory::class,
                    ],
                ],
            ],
        ];
    }
}

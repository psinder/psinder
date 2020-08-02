<?php

namespace Sip\Psinder\SharedKernel\Mezzio;

use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Sip\Psinder\SharedKernel\Infrastructure\Logging\LoggerFactory;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\ExecutionContext;

final class ConfigProvider
{
    private string $appName;

    public function __construct(string $appName)
    {
        $this->appName = $appName;
    }

    public function __invoke(): array {
        return [
            'dependencies' => [
                'factories'  => [
                    ExecutionContext::class =>  fn() => new ExecutionContext($this->appName),
                    LoggerFactory::class => static function (ContainerInterface $c) {
                        return new LoggerFactory($c->get(ExecutionContext::class));
                    },
                    Logger::class => static function (ContainerInterface $c) {
                        return $c->get(LoggerFactory::class)('main');
                    },
                ],
                'shared' => [
                    ExecutionContext::class => true,
                ]
            ],
        ];
    }
}
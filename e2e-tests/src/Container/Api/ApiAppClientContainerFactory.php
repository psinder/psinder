<?php

declare(strict_types=1);

namespace Sip\Psinder\E2E\Container\Api;

use DI;
use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;
use Sip\Psinder\E2E\Container\DefinitionsProvider;

final class ApiAppClientContainerFactory extends DefinitionsProvider
{
    public static function definitions() : array
    {
        return [
            'app.url' => getenv('APP_URL'),
            'app.client' => DI\factory(function (ContainerInterface $container) {
                return new Client([
                    'handler' => $container->get('guzzle.stack'),
                    'base_uri' => $container->get('app.url'),
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ]
                ]);
            })
        ];
    }
}

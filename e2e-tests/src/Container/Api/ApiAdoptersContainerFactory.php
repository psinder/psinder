<?php

declare(strict_types=1);

namespace Sip\Psinder\E2E\Container\Api;

use DI;
use Psr\Container\ContainerInterface;
use Sip\Psinder\E2E\Collection\Adopters;
use Sip\Psinder\E2E\Collection\Api\ApiAdopters;
use Sip\Psinder\E2E\Collection\Tokens;
use Sip\Psinder\E2E\Container\DefinitionsProvider;

final class ApiAdoptersContainerFactory extends DefinitionsProvider
{
    public static function definitions() : array
    {
        return [
            Adopters::class => DI\get(ApiAdopters::class),
            ApiAdopters::class => DI\factory(function (ContainerInterface $container) {
                return new ApiAdopters(
                    $container->get('app.client'),
                    $container->get(Tokens::class)
                );
            })
        ];
    }
}

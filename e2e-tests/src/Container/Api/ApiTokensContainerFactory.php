<?php

declare(strict_types=1);

namespace Sip\Psinder\E2E\Container\Api;

use DI;
use Psr\Container\ContainerInterface;
use Sip\Psinder\E2E\Collection\Api\ApiTokens;
use Sip\Psinder\E2E\Collection\Tokens;
use Sip\Psinder\E2E\Container\DefinitionsProvider;
use Sip\Psinder\SharedKernel\UI\Http\RequestBuilderFactory;

final class ApiTokensContainerFactory extends DefinitionsProvider
{
    public static function definitions() : array
    {
        return [
            Tokens::class => DI\get(ApiTokens::class),
            ApiTokens::class => DI\factory(function (ContainerInterface $container) {
                return new ApiTokens($container->get('app.client'), $container->get(RequestBuilderFactory::class));
            })
        ];
    }
}

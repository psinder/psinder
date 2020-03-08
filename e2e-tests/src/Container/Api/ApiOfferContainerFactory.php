<?php

declare(strict_types=1);

namespace Sip\Psinder\E2E\Container\Api;

use DI;
use Psr\Container\ContainerInterface;
use Sip\Psinder\E2E\Collection\Api\ApiOffers;
use Sip\Psinder\E2E\Collection\Offers;
use Sip\Psinder\E2E\Collection\Tokens;
use Sip\Psinder\E2E\Container\DefinitionsProvider;

final class ApiOfferContainerFactory extends DefinitionsProvider
{
    public static function definitions() : array
    {
        return [
            Offers::class => DI\get(ApiOffers::class),
            ApiOffers::class => DI\factory(function (ContainerInterface $container) {
                return new ApiOffers(
                    $container->get('app.client'),
                    $container->get(Tokens::class)
                );
            })
        ];
    }
}

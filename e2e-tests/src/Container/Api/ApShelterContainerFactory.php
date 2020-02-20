<?php

declare(strict_types=1);

namespace Sip\Psinder\E2E\Container\Api;

use DI;
use Psr\Container\ContainerInterface;
use Sip\Psinder\E2E\Collection\Api\ApiOffers;
use Sip\Psinder\E2E\Collection\Api\ApiShelters;
use Sip\Psinder\E2E\Collection\Offers;
use Sip\Psinder\E2E\Collection\Shelters;
use Sip\Psinder\E2E\Container\ContainerFactory;
use Sip\Psinder\E2E\Container\DefinitionsProvider;
use Sip\Psinder\SharedKernel\UI\Http\RequestBuilderFactory;

final class ApShelterContainerFactory extends DefinitionsProvider
{
    public static function definitions() : array
    {
        return [
            Shelters::class => DI\get(ApiShelters::class),
            ApiShelters::class => DI\factory(function (ContainerInterface $container) {
                return new ApiShelters($container->get('app.client'), $container->get(RequestBuilderFactory::class));
            })
        ];
    }
}

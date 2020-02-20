<?php

declare(strict_types=1);

namespace App;

use Sip\Psinder\Adoption\Application\Command\Adopter\RegisterAdopter\RegisterAdopter;
use Sip\Psinder\Adoption\Application\Command\Adopter\RegisterAdopter\RegisterAdopterHandler;
use Sip\Psinder\Adoption\Application\Command\Shelter\PostOffer\PostOffer;
use Sip\Psinder\Adoption\Application\Command\Shelter\PostOffer\PostOfferHandler;
use Sip\Psinder\Adoption\Application\Command\Shelter\RegisterShelter\RegisterShelter;
use Sip\Psinder\Adoption\Application\Command\Shelter\RegisterShelter\RegisterShelterHandler;
use Sip\Psinder\Adoption\Application\Query\Shelter\GetOfferDetails\GetOfferDetails;
use Sip\Psinder\Adoption\Application\Query\Shelter\GetOfferDetails\GetOfferDetailsHandler;

return [
    'messenger' => [
        'default_bus'        => 'messenger.command.bus',
        'buses'              => [
            'messenger.command.bus' => [
                'handlers'   => [
                    PostOffer::class => [PostOfferHandler::class],
                    RegisterShelter::class => [RegisterShelterHandler::class],
                    RegisterAdopter::class => [RegisterAdopterHandler::class]
                ],
                'middleware' => [
                    'messenger.command.middleware.sender',
                    'messenger.command.middleware.handler'
                ],
                'routes'     => [],
            ],
            'messenger.query.bus'   => [
                'handlers'   => [
                    GetOfferDetails::class => [GetOfferDetailsHandler::class]
                ],
                'middleware' => [
                    'messenger.query.middleware.sender',
                    'messenger.query.middleware.handler'
                ],
                'routes'     => [],
            ],
            'messenger.event.bus'   => [
                'allows_no_handler' => true,
                'handlers'   => [],
                'middleware' => [
                    'messenger.event.middleware.sender',
                    'messenger.event.middleware.handler'
                ],
                'routes'     => [],
            ],
        ],
    ],
];

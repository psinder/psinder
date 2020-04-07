<?php

declare(strict_types=1);

namespace App;

use Sip\Psinder\Adoption\Application\Command\Adopter\ApplyForAdoption\ApplyForAdoption;
use Sip\Psinder\Adoption\Application\Command\Adopter\ApplyForAdoption\ApplyForAdoptionHandler;
use Sip\Psinder\Adoption\Application\Command\Adopter\GivePet\GivePet;
use Sip\Psinder\Adoption\Application\Command\Adopter\GivePet\GivePetHandler;
use Sip\Psinder\Adoption\Application\Command\Adopter\RegisterAdopter\RegisterAdopter;
use Sip\Psinder\Adoption\Application\Command\Adopter\RegisterAdopter\RegisterAdopterHandler;
use Sip\Psinder\Adoption\Application\Command\CompleteTransfer\CompleteTransfer;
use Sip\Psinder\Adoption\Application\Command\CompleteTransfer\CompleteTransferHandler;
use Sip\Psinder\Adoption\Application\Command\ScheduleTransfer\ScheduleTransfer;
use Sip\Psinder\Adoption\Application\Command\ScheduleTransfer\ScheduleTransferHandler;
use Sip\Psinder\Adoption\Application\Command\Shelter\PostOffer\PostOffer;
use Sip\Psinder\Adoption\Application\Command\Shelter\PostOffer\PostOfferHandler;
use Sip\Psinder\Adoption\Application\Command\Shelter\RegisterShelter\RegisterShelter;
use Sip\Psinder\Adoption\Application\Command\Shelter\RegisterShelter\RegisterShelterHandler;
use Sip\Psinder\Adoption\Application\Command\Shelter\SelectApplication\SelectApplication;
use Sip\Psinder\Adoption\Application\Command\Shelter\SelectApplication\SelectApplicationHandler;
use Sip\Psinder\Adoption\Application\Query\Offer\GetOfferApplications\GetOfferApplications;
use Sip\Psinder\Adoption\Application\Query\Offer\GetOfferApplications\GetOfferApplicationsHandler;
use Sip\Psinder\Adoption\Application\Query\Offer\GetOfferDetails\GetOfferDetails;
use Sip\Psinder\Adoption\Application\Query\Offer\GetOfferDetails\GetOfferDetailsHandler;

return [
    'messenger' => [
        'default_bus'        => 'messenger.command.bus',
        'buses'              => [
            'messenger.command.bus' => [
                'handlers'   => [
                    PostOffer::class => [PostOfferHandler::class],
                    RegisterShelter::class => [RegisterShelterHandler::class],
                    RegisterAdopter::class => [RegisterAdopterHandler::class],
                    ApplyForAdoption::class => [ApplyForAdoptionHandler::class],
                    SelectApplication::class => [SelectApplicationHandler::class],
                    ScheduleTransfer::class => [ScheduleTransferHandler::class],
                    GivePet::class => [GivePetHandler::class],
                    CompleteTransfer::class => [CompleteTransferHandler::class],
                ],
                'middleware' => [
                    'messenger.command.middleware.sender',
                    'messenger.command.middleware.handler'
                ],
                'routes'     => [],
            ],
            'messenger.query.bus'   => [
                'handlers'   => [
                    GetOfferDetails::class => [GetOfferDetailsHandler::class],
                    GetOfferApplications::class => [GetOfferApplicationsHandler::class]
                ],
                'middleware' => [
                    'messenger.query.middleware.sender',
                    'messenger.query.middleware.handler'
                ],
                'routes' => [],
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

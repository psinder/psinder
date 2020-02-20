<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Sip\Psinder\Adoption\Application\Command\PetFactory;
use Sip\Psinder\Adoption\Application\Command\Shelter\PostOffer\PostOfferHandler;
use Sip\Psinder\Adoption\Application\Query\Shelter\GetOfferDetails\GetOfferDetailsHandler;
use Sip\Psinder\Adoption\Application\Query\Shelter\OfferDetailsRepository;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Domain\Shelter\Shelters;

return [
    'dependencies' => [
        'factories'  => [
            PetFactory::class => static function () {
                return new PetFactory();
            },
            PostOfferHandler::class => static function (ContainerInterface $container) {
                return new PostOfferHandler(
                    $container->get(Shelters::class),
                    $container->get(Offers::class),
                    $container->get(PetFactory::class)
                );
            },
            GetOfferDetailsHandler::class => static function (ContainerInterface $container) {
                return new GetOfferDetailsHandler($container->get(OfferDetailsRepository::class));
            },
        ],
    ],
];

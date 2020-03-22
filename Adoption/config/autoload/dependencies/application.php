<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Sip\Psinder\Adoption\Application\Command\PetFactory;
use Sip\Psinder\Adoption\Application\Command\Shelter\PostOffer\PostOfferHandler;
use Sip\Psinder\Adoption\Application\Command\Shelter\RegisterShelter\RegisterShelterHandler;
use Sip\Psinder\Adoption\Application\Command\Shelter\ShelterFactory;
use Sip\Psinder\Adoption\Application\Query\Offer\GetOfferDetails\GetOfferDetailsHandler;
use Sip\Psinder\Adoption\Application\Query\Offer\OfferRepository;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Domain\Shelter\Shelters;

return [
    'dependencies' => [
        'factories'  => [],
    ],
];

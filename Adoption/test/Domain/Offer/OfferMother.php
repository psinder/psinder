<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Domain\Offer;

use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Offer\Offer;
use Sip\Psinder\Adoption\Domain\Offer\OfferId;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;

final class OfferMother
{
    public static function exampleId() : OfferId
    {
        return new OfferId(OfferBuilder::EXAMPLE_ID);
    }

    public static function randomId() : OfferId
    {
        return new OfferId(Uuid::uuid4()->toString());
    }

    public static function example() : Offer
    {
        return (new OfferBuilder())
            ->get();
    }

    public static function withShelter(ShelterId $shelterId) : Offer
    {
        return (new OfferBuilder())
            ->shelter($shelterId)
            ->get();
    }

    public static function withSelectedAdopter(AdopterId $adopterId) : Offer
    {
        return (new OfferBuilder())
            ->selectedAdopter($adopterId)
            ->get();
    }
}

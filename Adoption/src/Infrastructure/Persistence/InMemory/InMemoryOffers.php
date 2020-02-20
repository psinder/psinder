<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory;

use Sip\Psinder\Adoption\Domain\Offer\Offer;
use Sip\Psinder\Adoption\Domain\Offer\OfferId;
use Sip\Psinder\Adoption\Domain\Offer\OfferNotFound;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use function array_values;
use function Functional\select;

final class InMemoryOffers implements Offers
{
    /** @var Offer[] */
    private $offers;
    /** @var EventPublisher */
    private $eventPublisher;

    public function __construct(EventPublisher $eventPublisher)
    {
        $this->offers         = [];
        $this->eventPublisher = $eventPublisher;
    }

    public function create(Offer $offer) : void
    {
        $this->offers[$offer->id()->toScalar()] = $offer;

        $offer->publishEvents($this->eventPublisher);
    }

    public function update(Offer $offer) : void
    {
        $this->get($offer->id());

        $this->offers[$offer->id()->toScalar()] = $offer;

        $offer->publishEvents($this->eventPublisher);
    }

    public function get(OfferId $id) : Offer
    {
        $offer = $this->offers[$id->toScalar()] ?? null;

        if ($offer === null) {
            throw OfferNotFound::forId($id);
        }

        return $offer;
    }

    /** @return Offer[] */
    public function forShelter(ShelterId $shelterId) : array
    {
        return array_values(select($this->offers, static function (Offer $offer) use ($shelterId) : bool {
            return $offer->shelterId()->equals($shelterId);
        }));
    }
}

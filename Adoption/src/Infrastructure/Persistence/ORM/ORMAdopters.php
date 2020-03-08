<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Sip\Psinder\Adoption\Domain\Adopter\Adopter;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterNotFound;
use Sip\Psinder\Adoption\Domain\Adopter\Adopters;
use Sip\Psinder\Adoption\Domain\Offer\Offer;
use Sip\Psinder\Adoption\Domain\Offer\OfferId;
use Sip\Psinder\Adoption\Domain\Offer\OfferNotFound;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\ORM\ORMCollection;
use Throwable;
use function assert;

final class ORMAdopters implements Adopters
{
    private ORMCollection $collection;

    public function __construct(
        EntityManagerInterface $entityManager,
        EventPublisher $eventPublisher
    ) {
        $this->collection = new ORMCollection(
            $entityManager,
            $eventPublisher,
            Adopter::class,
            static fn(AdopterId $id): Throwable => AdopterNotFound::forId($id)
        );
    }

    public function create(Adopter $offer) : void
    {
        $this->collection->create($offer);
    }

    /** @throws AdopterNotFound */
    public function update(Adopter $offer) : void
    {
        $this->collection->update($offer);
    }

    /** @throws AdopterNotFound */
    public function get(AdopterId $id) : Adopter
    {
        $offer = $this->collection->get($id);

        assert($offer instanceof Adopter);

        return $offer;
    }
}

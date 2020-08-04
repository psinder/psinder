<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Sip\Psinder\Adoption\Domain\Offer\Offer;
use Sip\Psinder\Adoption\Domain\Offer\OfferId;
use Sip\Psinder\Adoption\Domain\Offer\OfferNotFound;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\ORM\ORMCollection;
use Throwable;

use function assert;

final class ORMOffers implements Offers
{
    private ORMCollection $collection;

    public function __construct(
        EntityManagerInterface $entityManager,
        EventPublisher $eventPublisher
    ) {
        $this->collection = new ORMCollection(
            $entityManager,
            $eventPublisher,
            Offer::class,
            static fn (OfferId $id): Throwable => OfferNotFound::forId($id)
        );
    }

    public function create(Offer $offer): void
    {
        $this->collection->create($offer);
    }

    /** @throws OfferNotFound */
    public function update(Offer $offer): void
    {
        $this->collection->update($offer);
    }

    /** @throws OfferNotFound */
    public function get(OfferId $id): Offer
    {
        $offer = $this->collection->get($id);

        assert($offer instanceof Offer);

        return $offer;
    }

    /** @return Offer[] */
    public function forShelter(ShelterId $shelterId): array
    {
        $qb = $this->collection->entityManager()
            ->createQueryBuilder();

        $qb->select('o')
            ->from(Offer::class, 'o')
            ->where($qb->expr()->eq('o.shelterId', ':id'))
            ->setParameter('id', $shelterId->toScalar());

        return $qb->getQuery()->getResult();
    }
}

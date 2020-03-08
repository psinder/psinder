<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Sip\Psinder\Adoption\Domain\Shelter\Shelter;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterNotFound;
use Sip\Psinder\Adoption\Domain\Shelter\Shelters;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\Persistence\ORM\ORMCollection;
use Throwable;
use function assert;

final class ORMShelters implements Shelters
{
    private ORMCollection $collection;

    public function __construct(EntityManagerInterface $entityManager, EventPublisher $eventPublisher)
    {
        $this->collection = new ORMCollection(
            $entityManager,
            $eventPublisher,
            Shelter::class,
            static fn(ShelterId $id): Throwable => ShelterNotFound::forId($id)
        );
    }

    public function create(Shelter $shelter) : void
    {
        $this->collection->create($shelter);
    }

    /** @throws ShelterNotFound */
    public function update(Shelter $shelter) : void
    {
        $this->collection->update($shelter);
    }

    /** @throws ShelterNotFound */
    public function get(ShelterId $id) : Shelter
    {
        $shelter = $this->collection->get($id);

        assert($shelter instanceof Shelter);

        return $shelter;
    }

    public function exists(ShelterId $id) : bool
    {
        return $this->collection->exists($id);
    }
}

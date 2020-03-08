<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory;

use Sip\Psinder\Adoption\Domain\Shelter\Shelter;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterNotFound;
use Sip\Psinder\Adoption\Domain\Shelter\Shelters;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use function array_key_exists;

final class InMemoryShelters implements Shelters
{
    /** @var Shelter[] */
    private array $shelters;
    private EventPublisher $eventPublisher;

    public function __construct(EventPublisher $eventPublisher)
    {
        $this->shelters       = [];
        $this->eventPublisher = $eventPublisher;
    }

    public function create(Shelter $shelter) : void
    {
        $this->shelters[$shelter->id()->toScalar()] = $shelter;

        $shelter->publishEvents($this->eventPublisher);
    }

    public function update(Shelter $shelter) : void
    {
        if (! $this->exists($shelter->id())) {
            throw ShelterNotFound::forId($shelter->id());
        }

        $this->shelters[$shelter->id()->toScalar()] = $shelter;

        $shelter->publishEvents($this->eventPublisher);
    }

    public function get(ShelterId $id) : Shelter
    {
        $shelter = $this->shelters[$id->toScalar()] ?? null;

        if ($shelter === null) {
            throw ShelterNotFound::forId($id);
        }

        return $shelter;
    }

    public function exists(ShelterId $id) : bool
    {
        return array_key_exists($id->toScalar(), $this->shelters);
    }
}

<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory;

use Sip\Psinder\Adoption\Domain\Adopter\Adopter;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterNotFound;
use Sip\Psinder\Adoption\Domain\Adopter\Adopters;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use function array_key_exists;

final class InMemoryAdopters implements Adopters
{
    /** @var Adopter[] */
    private $adopters;
    /** @var EventPublisher */
    private $eventPublisher;

    public function __construct(EventPublisher $eventPublisher)
    {
        $this->adopters       = [];
        $this->eventPublisher = $eventPublisher;
    }

    public function create(Adopter $adopter) : void
    {
        $this->adopters[$adopter->id()->toScalar()] = $adopter;

        $adopter->publishEvents($this->eventPublisher);
    }

    public function update(Adopter $adopter) : void
    {
        $exists = array_key_exists($adopter->id()->toScalar(), $this->adopters);

        if (! $exists) {
            throw AdopterNotFound::forId($adopter->id());
        }

        $this->adopters[$adopter->id()->toScalar()] = $adopter;

        $adopter->publishEvents($this->eventPublisher);
    }

    public function get(AdopterId $adopterId) : Adopter
    {
        $adopter = $this->adopters[$adopterId->toScalar()] ?? null;

        if ($adopter === null) {
            throw AdopterNotFound::forId($adopterId);
        }

        return $adopter;
    }
}

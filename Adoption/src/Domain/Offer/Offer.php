<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Offer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Offer\Application\Application;
use Sip\Psinder\Adoption\Domain\Offer\Application\ApplicationSelected;
use Sip\Psinder\Adoption\Domain\Offer\Application\ApplicationSent;
use Sip\Psinder\Adoption\Domain\Pet\Pet;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;
use Sip\Psinder\Adoption\Domain\Transfer\CannotScheduleTransfer;
use Sip\Psinder\Adoption\Domain\Transfer\Transfer;
use Sip\Psinder\Adoption\Domain\Transfer\TransferId;
use Sip\Psinder\SharedKernel\Domain\AggregateRoot;
use Sip\Psinder\SharedKernel\Domain\Event;
use Sip\Psinder\SharedKernel\Domain\EventsPublishingAggregateRoot;
use function Functional\some;

final class Offer implements AggregateRoot
{
    use EventsPublishingAggregateRoot;

    private const OPEN   = true;
    private const CLOSED = false;

    private OfferId $id;
    private ShelterId $shelterId;
    private Pet $pet;
    /**
     * @phpstan-var Collection<int, Application>
     * @var Collection|Application[]
     */
    private Collection $applications;
    private ?AdopterId $selectedAdopter = null;
    private bool $isOpen;

    /**
     * @param Event[] $events
     */
    private function __construct(
        OfferId $id,
        ShelterId $shelterId,
        Pet $pet,
        bool $isOpen = self::OPEN,
        array $events = []
    ) {
        $this->shelterId    = $shelterId;
        $this->pet          = $pet;
        $this->id           = $id;
        $this->events       = $events;
        $this->isOpen       = $isOpen;
        $this->applications = new ArrayCollection();
    }

    public static function post(OfferId $id, ShelterId $shelterId, Pet $pet) : self
    {
        return new self($id, $shelterId, $pet, self::OPEN, [OfferPosted::occur($id, $shelterId, $pet)]);
    }

    public function id() : OfferId
    {
        return $this->id;
    }

    public function shelterId() : ShelterId
    {
        return $this->shelterId;
    }

    public function apply(AdopterId $adopterId) : void
    {
        if (! $this->isOpen) {
            throw OfferNotOpen::forId($this->id);
        }

        if ($this->alreadyApplied($adopterId)) {
            throw AlreadyApplied::forAdopterAndOffer(
                $adopterId,
                $this->id
            );
        }

        $this->applications[] = Application::prepare($this, $adopterId);
        $this->events[]       = ApplicationSent::occur($adopterId, $this->id);
    }

    public function selectApplication(AdopterId $adopterId) : void
    {
        $this->selectedAdopter = $adopterId;
        $this->events[]        = ApplicationSelected::occur($adopterId, $this->id);

        $this->close();
    }

    private function close() : void
    {
        $this->isOpen   = self::CLOSED;
        $this->events[] = OfferClosed::occur($this->id);
    }

    private function alreadyApplied(AdopterId $adopterId) : bool
    {
        return some(
            $this->applications,
            static fn(Application $application): bool => $application->adopterId()->equals($adopterId)
        );
    }

    public function prepareTransfer(TransferId $transferId) : Transfer
    {
        if ($this->selectedAdopter === null) {
            throw CannotScheduleTransfer::applicationNotSelected($this->id);
        }

        return Transfer::schedule($transferId, $this->id, $this->pet, $this->selectedAdopter);
    }
}

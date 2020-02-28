<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Offer;

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
use Sip\Psinder\SharedKernel\Domain\Identity\Identity;
use function Functional\some;

final class Offer implements AggregateRoot
{
    use EventsPublishingAggregateRoot;

    private const OPEN   = true;
    private const CLOSED = false;

    /** @var OfferId */
    private $id;

    /** @var ShelterId */
    private $shelterId;

    /** @var Pet */
    private $pet;

    /** @var Application[] */
    private $applications = [];

    /** @var AdopterId|null */
    private $selectedAdopter;

    /** @var bool */
    private $isOpen;

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
        $this->shelterId = $shelterId;
        $this->pet       = $pet;
        $this->id        = $id;
        $this->events    = $events;
        $this->isOpen    = $isOpen;
    }

    public static function post(OfferId $id, ShelterId $shelterId, Pet $pet) : self
    {
        return new self($id, $shelterId, $pet, self::OPEN, [OfferPosted::occur($id, $shelterId, $pet)]);
    }

    /**
     * @return OfferId
     */
    public function id() : Identity
    {
        return $this->id;
    }

    public function shelterId() : ShelterId
    {
        return $this->shelterId;
    }

    public function apply(Application $application) : void
    {
        if (! $this->isOpen) {
            throw OfferNotOpen::forId($this->id);
        }

        if ($this->alreadyApplied($application->adopterId())) {
            throw AlreadyApplied::forAdopterAndOffer(
                $application->adopterId(),
                $this->id
            );
        }

        $this->applications[] = $application;
        $this->events[]       = ApplicationSent::occur(
            $application->adopterId(),
            $this->id
        );
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
        return some($this->applications, static function (Application $application) use ($adopterId) : bool {
            return $application->adopterId()->equals($adopterId);
        });
    }

    public function prepareTransfer(TransferId $transferId) : Transfer
    {
        if ($this->selectedAdopter === null) {
            throw CannotScheduleTransfer::applicationNotSelected($this->id);
        }

        return Transfer::schedule($transferId, $this->id, $this->pet, $this->selectedAdopter);
    }
}

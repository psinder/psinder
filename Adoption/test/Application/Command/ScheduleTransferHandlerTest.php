<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Application\Command\ScheduleTransfer\ScheduleTransfer;
use Sip\Psinder\Adoption\Application\Command\ScheduleTransfer\ScheduleTransferHandler;
use Sip\Psinder\Adoption\Domain\Transfer\TransferScheduled;
use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryOffers;
use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryTransfers;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;
use Sip\Psinder\Adoption\Test\Domain\Offer\OfferBuilder;
use Sip\Psinder\Adoption\Test\Domain\Pet\PetMother;
use Sip\Psinder\Adoption\Test\Domain\Transfer\TransferMother;
use Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory\InMemoryOffersFactory;
use Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory\InMemoryTransfersFactory;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsInterceptingIsolatedTest;

final class ScheduleTransferHandlerTest extends TestCase
{
    use EventsInterceptingIsolatedTest;

    /** @var ScheduleTransferHandler */
    private $handler;

    /** @var InMemoryOffers */
    private $offers;

    /** @var InMemoryTransfers */
    private $transfers;

    public function setUp() : void
    {
        $this->offers    = InMemoryOffersFactory::create($this->eventPublisher());
        $this->transfers = InMemoryTransfersFactory::create($this->eventPublisher());
        $this->handler   = new ScheduleTransferHandler($this->offers, $this->transfers);
    }

    public function testSchedulesTransfer() : void
    {
        // Given
        $id        = TransferMother::randomId()->toScalar();
        $adopterId = AdopterMother::exampleId();
        $pet       = PetMother::example();
        $offer     = (new OfferBuilder())
            ->pet($pet)
            ->selectedAdopter($adopterId)
            ->get();

        $this->offers->create($offer);
        $this->eventPublisher()->clear();

        // When
        $command = new ScheduleTransfer($id, $offer->id()->toScalar());
        ($this->handler)($command);

        // Then
        $this->assertPublishedEvents(
            new TransferScheduled(
                $id,
                $offer->id()->toScalar(),
                $pet->toPayload(),
                $adopterId->toScalar(),
                new DateTimeImmutable()
            )
        );
    }

    protected function context() : TestCase
    {
        return $this;
    }
}

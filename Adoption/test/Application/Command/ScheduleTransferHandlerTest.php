<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Application\Command\ScheduleTransfer\ScheduleTransfer;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Domain\Transfer\Transfers;
use Sip\Psinder\Adoption\Domain\Transfer\TransferScheduled;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;
use Sip\Psinder\Adoption\Test\Domain\Offer\OfferBuilder;
use Sip\Psinder\Adoption\Test\Domain\Pet\PetMother;
use Sip\Psinder\Adoption\Test\Domain\Transfer\TransferMother;
use Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory\InMemoryTransfersFactory;
use Sip\Psinder\Adoption\Test\TransactionalTestCase;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;
use Sip\Psinder\SharedKernel\Domain\EventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\InterceptingEventPublisher;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsPublishingTest;

final class ScheduleTransferHandlerTest extends TransactionalTestCase
{
    use EventsPublishingTest;

    private Offers $offers;
    private Transfers $transfers;
    private CommandBus $bus;
    private InterceptingEventPublisher $eventPublisher;

    public function setUp() : void
    {
        $this->eventPublisher = new InterceptingEventPublisher();
        $this->transfers      = InMemoryTransfersFactory::create($this->eventPublisher());
        $this->overrideServiceAliasWithInstance(EventPublisher::class, $this->eventPublisher());
        $this->overrideServiceAliasWithInstance(Transfers::class, $this->transfers);

        parent::setUp();

        $this->offers = $this->get(Offers::class);
        $this->bus    = $this->get(CommandBus::class);
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
        $this->bus->dispatch($command);

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

    protected function eventPublisher() : InterceptingEventPublisher
    {
        return $this->eventPublisher;
    }
}

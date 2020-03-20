<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Domain\Transfer;

use Sip\Psinder\Adoption\Domain\Transfer\Transfer;
use Sip\Psinder\Adoption\Domain\Transfer\TransferCompleted;
use Sip\Psinder\Adoption\Domain\Transfer\TransferNotFound;
use Sip\Psinder\Adoption\Domain\Transfer\Transfers;
use Sip\Psinder\Adoption\Domain\Transfer\TransferScheduled;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;
use Sip\Psinder\Adoption\Test\Domain\Offer\OfferMother;
use Sip\Psinder\Adoption\Test\Domain\Pet\PetMother;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsInterceptingIsolatedTest;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\TestCaseAwareTrait;

trait TransfersTest
{
    use EventsInterceptingIsolatedTest;
    use TestCaseAwareTrait;

    public function testPublishesEventsWhenCreatingTransfer() : void
    {
        $id        = TransferMother::randomId();
        $offerId   = OfferMother::randomId();
        $pet       = PetMother::example();
        $adopterId = AdopterMother::randomId();

        $offer = Transfer::schedule(
            $id,
            $offerId,
            $pet,
            $adopterId
        );

        $this->transfers()->create($offer);

        $this->assertPublishedEvents(TransferScheduled::occur(
            $id,
            $offerId,
            $pet,
            $adopterId
        ));
    }

    public function testPublishesEventsWhenUpdatingTransfer() : void
    {
        $transfer = TransferMother::example();

        $this->transfers()->create($transfer);

        $this->eventPublisher()->clear();

        $transfer->complete();

        $this->transfers()->update($transfer);

        $this->assertPublishedEvent(TransferCompleted::occur(
            $transfer->id(),
            $transfer->adopterId(),
            $transfer->pet()
        ));
    }

    public function testFetchesExistingTransfer() : void
    {
        $transfer = TransferMother::example();
        $this->transfers()->create($transfer);

        $result = $this->transfers()->get($transfer->id());

        $this->context()::assertEquals($transfer, $result);
    }

    public function testFetchesNotExistentTransferAndThrows() : void
    {
        $transfer = TransferMother::example();
        $otherId  = TransferMother::randomId();

        $this->transfers()->create($transfer);

        $this->expectException(TransferNotFound::class);

        $this->transfers()->get($otherId);
    }

    public function testUpdatesNotExistentTransferAndThrows() : void
    {
        $shelter = TransferMother::example();

        $this->context()->expectException(TransferNotFound::class);

        $this->transfers()->update($shelter);
    }

    abstract protected function transfers() : Transfers;
}

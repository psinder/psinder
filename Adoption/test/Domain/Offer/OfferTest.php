<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Domain\Offer;

use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Domain\Offer\AlreadyApplied;
use Sip\Psinder\Adoption\Domain\Offer\Application\ApplicationSent;
use Sip\Psinder\Adoption\Domain\Offer\OfferNotOpen;
use Sip\Psinder\Adoption\Domain\Transfer\CannotScheduleTransfer;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;
use Sip\Psinder\Adoption\Test\Domain\Transfer\TransferMother;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsInterceptingIsolatedTest;

final class OfferTest extends TestCase
{
    use EventsInterceptingIsolatedTest;

    public function testSendsApplication(): void
    {
        $offer     = OfferMother::example();
        $adopterId = AdopterMother::randomId();

        $offer->apply($adopterId);

        $offer->publishEvents($this->eventPublisher());

        $this->assertPublishedEvent(
            ApplicationSent::occur(
                $adopterId,
                $offer->id()
            )
        );
    }

    public function testSendsTwoApplicationsForDifferentAdopters(): void
    {
        $offer = OfferMother::example();

        $adopterId      = AdopterMother::randomId();
        $otherAdopterId = AdopterMother::randomId();

        $offer->apply($adopterId);
        $offer->apply($otherAdopterId);

        $offer->publishEvents($this->eventPublisher());

        $this->assertPublishedEvent(ApplicationSent::occur($adopterId, $offer->id()));
        $this->assertPublishedEvent(ApplicationSent::occur($otherAdopterId, $offer->id()));
    }

    public function testSendsTwoApplicationsForTheSameAdopterAndThrows(): void
    {
        $offer     = OfferMother::example();
        $adopterId = AdopterMother::randomId();

        $offer->apply($adopterId);

        $this->expectException(AlreadyApplied::class);

        $offer->apply($adopterId);
    }

    public function testSendsApplicationAfterApplicationWasSelectedAndThrows(): void
    {
        $adopterId = AdopterMother::randomId();
        $offer     = (new OfferBuilder())
            ->selectedAdopter($adopterId)
            ->get();

        $otherAdopterId = AdopterMother::randomId();

        $this->expectException(OfferNotOpen::class);

        $offer->apply($otherAdopterId);
    }

    public function testSchedulesTransfer(): void
    {
        $transferId = TransferMother::randomId();
        $adopterId  = AdopterMother::randomId();

        $offer = (new OfferBuilder())
            ->selectedAdopter($adopterId)
            ->get();

        $result = $offer->prepareTransfer($transferId);

        $this->context()::assertTrue($result->adopterId()->equals($adopterId));
        $this->context()::assertTrue($result->id()->equals($transferId));
    }

    public function testSchedulesTransferForOfferWithoutSelectedApplicationAndThrows(): void
    {
        $transferId = TransferMother::randomId();

        $offer = OfferMother::example();

        $this->context()->expectException(CannotScheduleTransfer::class);

        $offer->prepareTransfer($transferId);
    }

    protected function context(): TestCase
    {
        return $this;
    }
}

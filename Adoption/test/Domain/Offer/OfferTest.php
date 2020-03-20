<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Domain\Offer;

use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Domain\Offer\AlreadyApplied;
use Sip\Psinder\Adoption\Domain\Offer\Application\ApplicationSent;
use Sip\Psinder\Adoption\Domain\Offer\OfferNotOpen;
use Sip\Psinder\Adoption\Domain\Transfer\CannotScheduleTransfer;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;
use Sip\Psinder\Adoption\Test\Domain\Application\ApplicationMother;
use Sip\Psinder\Adoption\Test\Domain\Transfer\TransferMother;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsInterceptingIsolatedTest;

final class OfferTest extends TestCase
{
    use EventsInterceptingIsolatedTest;

    public function testSendsApplication() : void
    {
        $offer       = OfferMother::example();
        $application = ApplicationMother::example();

        $offer->apply($application);

        $offer->publishEvents($this->eventPublisher());

        $this->assertPublishedEvent(
            ApplicationSent::occur(
                $application->adopterId(),
                $offer->id()
            )
        );
    }

    public function testSendsTwoApplicationsForDifferentAdopters() : void
    {
        $offer = OfferMother::example();

        $adopterId   = AdopterMother::randomId();
        $application = ApplicationMother::withAdopter($adopterId);

        $otherAdopterId   = AdopterMother::randomId();
        $otherApplication = ApplicationMother::withAdopter($otherAdopterId);

        $offer->apply($application);
        $offer->apply($otherApplication);

        $offer->publishEvents($this->eventPublisher());

        $this->assertPublishedEvent(ApplicationSent::occur($adopterId, $offer->id()));
        $this->assertPublishedEvent(ApplicationSent::occur($otherAdopterId, $offer->id()));
    }

    public function testSendsTwoApplicationsForTheSameAdopterAndThrows() : void
    {
        $offer            = OfferMother::example();
        $adopterId        = AdopterMother::randomId();
        $application      = ApplicationMother::withAdopter($adopterId);
        $otherApplication = ApplicationMother::withAdopter($adopterId);

        $offer->apply($application);

        $this->expectException(AlreadyApplied::class);

        $offer->apply($otherApplication);
    }

    public function testSendsApplicationAfterApplicationWasSelectedAndThrows() : void
    {
        $application = ApplicationMother::example();
        $offer       = (new OfferBuilder())
            ->selectedAdopter($application->adopterId())
            ->get();

        $otherAdopterId   = AdopterMother::randomId();
        $otherApplication = ApplicationMother::withAdopter($otherAdopterId);

        $this->expectException(OfferNotOpen::class);

        $offer->apply($otherApplication);
    }

    public function testSchedulesTransfer() : void
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

    public function testSchedulesTransferForOfferWithoutSelectedApplicationAndThrows() : void
    {
        $transferId = TransferMother::randomId();

        $offer = OfferMother::example();

        $this->context()->expectException(CannotScheduleTransfer::class);

        $offer->prepareTransfer($transferId);
    }

    protected function context() : TestCase
    {
        return $this;
    }
}

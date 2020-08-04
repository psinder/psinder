<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Domain\Offer;

use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Domain\Offer\Application\ApplicationSent;
use Sip\Psinder\Adoption\Domain\Offer\Offer;
use Sip\Psinder\Adoption\Domain\Offer\OfferId;
use Sip\Psinder\Adoption\Domain\Offer\OfferNotFound;
use Sip\Psinder\Adoption\Domain\Offer\OfferPosted;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;
use Sip\Psinder\Adoption\Test\Domain\Pet\PetMother;
use Sip\Psinder\Adoption\Test\Domain\Shelter\ShelterMother;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsPublishingTest;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\TestCaseAware;

trait OffersTest
{
    use EventsPublishingTest;
    use TestCaseAware;

    public function testPublishesEventsWhenCreatingOffer(): void
    {
        $id        = new OfferId(Uuid::uuid4()->toString());
        $shelterId = ShelterMother::randomId();
        $pet       = PetMother::example();

        $offer = Offer::post($id, $shelterId, $pet);

        $this->offers()->create($offer);

        $this->assertPublishedEvents(OfferPosted::occur($id, $shelterId, $pet));
    }

    public function testPublishesEventsWhenUpdatingOffer(): void
    {
        $offer     = OfferMother::example();
        $adopterId = AdopterMother::randomId();

        $this->offers()->create($offer);

        $this->eventPublisher()->clear();

        $offer->apply($adopterId);

        $this->offers()->update($offer);

        $this->assertPublishedEvents(ApplicationSent::occur($adopterId, $offer->id()));
    }

    public function testFetchesExistingOffer(): void
    {
        $offer = OfferMother::example();
        $this->offers()->create($offer);

        $result = $this->offers()->get($offer->id());

        $this->context()::assertEquals($offer, $result);
    }

    public function testFetchesNotExistentOfferAndThrows(): void
    {
        $offer   = OfferMother::example();
        $otherId = OfferMother::randomId();

        $this->offers()->create($offer);

        $this->expectException(OfferNotFound::class);

        $this->offers()->get($otherId);
    }

    public function testFetchesShelterOffers(): void
    {
        $shelterId = ShelterMother::randomId();

        $offer = OfferMother::withShelter($shelterId);
        $this->offers()->create($offer);

        $result = $this->offers()->forShelter($shelterId);

        $this->context()::assertEquals([$offer], $result);
    }

    public function testFetchesNoShelterOffersForNotExistentId(): void
    {
        $shelterId = ShelterMother::randomId();

        $offer = OfferMother::example();
        $this->offers()->create($offer);

        $result = $this->offers()->forShelter($shelterId);

        $this->context()::assertEmpty($result);
    }

    abstract protected function offers(): Offers;
}

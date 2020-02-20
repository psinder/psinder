<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command;

use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Application\Command\Adopter\ApplyForAdoption\ApplyForAdoption;
use Sip\Psinder\Adoption\Application\Command\Adopter\ApplyForAdoption\ApplyForAdoptionHandler;
use Sip\Psinder\Adoption\Domain\Offer\AlreadyApplied;
use Sip\Psinder\Adoption\Domain\Offer\Application\ApplicationSent;
use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryAdopters;
use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryOffers;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;
use Sip\Psinder\Adoption\Test\Domain\Offer\OfferMother;
use Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory\InMemoryAdoptersFactory;
use Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory\InMemoryOffersFactory;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsInterceptingTest;

final class ApplyForAdoptionHandlerTest extends TestCase
{
    use EventsInterceptingTest;

    /** @var ApplyForAdoptionHandler */
    private $handler;

    /** @var InMemoryOffers */
    private $offers;

    /** @var InMemoryAdopters */
    private $adopters;

    public function setUp() : void
    {
        $this->adopters = InMemoryAdoptersFactory::create($this->eventPublisher());
        $this->offers   = InMemoryOffersFactory::create($this->eventPublisher());
        $this->handler  = new ApplyForAdoptionHandler(
            $this->adopters,
            $this->offers
        );
    }

    public function testCanApply() : void
    {
        $adopter = AdopterMother::registeredExample();
        $offer   = OfferMother::example();

        $this->offers->create($offer);
        $this->adopters->create($adopter);

        $this->eventPublisher()->clear();

        $adopterId = $adopter->id();
        $offerId   = $offer->id();

        $command = new ApplyForAdoption(
            $adopterId->toScalar(),
            $offerId->toScalar()
        );

        ($this->handler)($command);

        $this->assertPublishedEvents(ApplicationSent::occur($adopterId, $offerId));
    }

    public function testCannotApplyTwice() : void
    {
        $adopter = AdopterMother::registeredExample();
        $offer   = OfferMother::example();

        $this->offers->create($offer);
        $this->adopters->create($adopter);

        $adopterId = $adopter->id()->toScalar();
        $offerId   = $offer->id()->toScalar();

        $command = new ApplyForAdoption(
            $adopterId,
            $offerId
        );

        ($this->handler)($command);

        $this->expectException(AlreadyApplied::class);

        ($this->handler)($command);
    }

    protected function context() : TestCase
    {
        return $this;
    }
}

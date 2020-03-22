<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command;

use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Application\Command\Adopter\ApplyForAdoption\ApplyForAdoption;
use Sip\Psinder\Adoption\Domain\Adopter\Adopters;
use Sip\Psinder\Adoption\Domain\Offer\AlreadyApplied;
use Sip\Psinder\Adoption\Domain\Offer\Application\ApplicationSent;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;
use Sip\Psinder\Adoption\Test\Domain\Offer\OfferMother;
use Sip\Psinder\Adoption\Test\TransactionalTestCase;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsPublishingTest;

final class ApplyForAdoptionHandlerTest extends TransactionalTestCase
{
    use EventsPublishingTest;

    private CommandBus $bus;
    private Adopters $adopters;
    private Offers $offers;

    public function setUp() : void
    {
        parent::setUp();

        $this->adopters = $this->get(Adopters::class);
        $this->offers   = $this->get(Offers::class);
        $this->bus      = $this->get(CommandBus::class);
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

        $this->bus->dispatch($command);

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

        $this->bus->dispatch($command);

        $this->expectException(AlreadyApplied::class);

        $this->bus->dispatch($command);
    }

    protected function context() : TestCase
    {
        return $this;
    }
}

<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command\Shelter;

use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Application\Command\Shelter\PostOffer\PostOffer;
use Sip\Psinder\Adoption\Domain\Offer\OfferPosted;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Domain\Shelter\Shelters;
use Sip\Psinder\Adoption\Test\Application\Command\PetMother;
use Sip\Psinder\Adoption\Test\Domain\Shelter\ShelterMother;
use Sip\Psinder\Adoption\Test\TransactionalTestCase;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsPublishingTest;

final class PostOfferHandlerTest extends TransactionalTestCase
{
    use EventsPublishingTest;

    private CommandBus$bus;
    private Shelters $shelters;
    private Offers $offers;

    public function setUp() : void
    {
        parent::setUp();

        $this->shelters = $this->get(Shelters::class);
        $this->offers   = $this->get(Offers::class);
        $this->bus      = $this->get(CommandBus::class);
    }

    public function testCreatesNewOffer() : void
    {
        $id      = Uuid::uuid4()->toString();
        $shelter = ShelterMother::registeredWithRandomId();
        $pet     = PetMother::example();

        $this->shelters->create($shelter);

        $this->eventPublisher()->clear();

        $command = new PostOffer(
            $id,
            $shelter->id()->toScalar(),
            $pet
        );

        $this->bus->dispatch($command);

        $this->assertPublishedEvents(
            new OfferPosted(
                $id,
                $shelter->id()->toScalar(),
                $pet->toArray(),
                new DateTimeImmutable()
            )
        );
    }

    public function testCreatesOfferForNotExistentShelter() : void
    {
        $id        = Uuid::uuid4()->toString();
        $shelterId = Uuid::uuid4()->toString();
        $pet       = PetMother::example();

        $command = new PostOffer(
            $id,
            $shelterId,
            $pet
        );

        $this->expectException(InvalidArgumentException::class);

        $this->bus->dispatch($command);
    }

    protected function context() : TestCase
    {
        return $this;
    }
}

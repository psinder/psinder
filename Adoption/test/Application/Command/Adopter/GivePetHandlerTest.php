<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command\Adopter;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Application\Command\Adopter\GivePet\GivePet;
use Sip\Psinder\Adoption\Domain\Adopter\Adopters;
use Sip\Psinder\Adoption\Domain\Adopter\ReceivedPet;
use Sip\Psinder\Adoption\Test\Application\Command\PetMother;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;
use Sip\Psinder\Adoption\Test\TransactionalTestCase;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsPublishingTest;

final class GivePetHandlerTest extends TransactionalTestCase
{
    use EventsPublishingTest;

    private CommandBus $bus;

    private Adopters $adopters;

    public function setUp(): void
    {
        parent::setUp();
        $this->bus      = $this->get(CommandBus::class);
        $this->adopters = $this->get(Adopters::class);
    }

    public function testGivesPet(): void
    {
        $adopter = AdopterMother::registeredExample();
        $pet     = PetMother::example();

        $this->adopters->create($adopter);

        $this->eventPublisher()->clear();

        $adopterId = $adopter->id()->toScalar();

        $this->bus->dispatch(new GivePet(
            $adopterId,
            $pet
        ));

        $this->assertPublishedEvent(new ReceivedPet(
            $adopterId,
            $pet->toArray(),
            new DateTimeImmutable()
        ));
    }

    protected function context(): TestCase
    {
        return $this;
    }
}

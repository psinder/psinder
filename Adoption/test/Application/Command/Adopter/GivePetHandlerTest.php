<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application\Command\Adopter;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Application\Command\Adopter\GivePet\GivePet;
use Sip\Psinder\Adoption\Application\Command\Adopter\GivePet\GivePetHandler;
use Sip\Psinder\Adoption\Domain\Adopter\ReceivedPet;
use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryAdopters;
use Sip\Psinder\Adoption\Test\Application\Command\PetFactoryFactory;
use Sip\Psinder\Adoption\Test\Application\Command\PetMother;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdopterMother;
use Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory\InMemoryAdoptersFactory;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsInterceptingIsolatedTest;

final class GivePetHandlerTest extends TestCase
{
    use EventsInterceptingIsolatedTest;

    /** @var GivePetHandler */
    private $handler;

    /** @var InMemoryAdopters */
    private $adopters;

    public function setUp() : void
    {
        $this->adopters = InMemoryAdoptersFactory::create($this->eventPublisher());
        $this->handler  = new GivePetHandler(
            $this->adopters,
            PetFactoryFactory::create()
        );
    }

    public function testGivesPet() : void
    {
        $adopter = AdopterMother::registeredExample();
        $pet     = PetMother::example();

        $this->adopters->create($adopter);

        $this->eventPublisher()->clear();

        $adopterId = $adopter->id()->toScalar();

        ($this->handler)(new GivePet(
            $adopterId,
            $pet
        ));

        $this->assertPublishedEvent(new ReceivedPet(
            $adopterId,
            $pet->toArray(),
            new DateTimeImmutable()
        ));
    }

    protected function context() : TestCase
    {
        return $this;
    }
}

<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Domain\Adopter;

use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Domain\Adopter\Adopter;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterId;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterName;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterNotFound;
use Sip\Psinder\Adoption\Domain\Adopter\AdopterRegistered;
use Sip\Psinder\Adoption\Domain\Adopter\Adopters;
use Sip\Psinder\Adoption\Domain\Adopter\ReceivedPet;
use Sip\Psinder\Adoption\Test\Domain\Pet\PetMother;
use Sip\Psinder\SharedKernel\Domain\Birthdate;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Domain\Gender;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsInterceptingIsolatedTest;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\TestCaseAware;

trait AdoptersTest
{
    use EventsInterceptingIsolatedTest;
    use TestCaseAware;

    public function testPublishesEventsWhenCreatingAdopter(): void
    {
        $id        = new AdopterId(Uuid::uuid4()->toString());
        $name      = AdopterName::fromFirstAndLastName('Foo', 'Bar');
        $birthdate = Birthdate::fromString('1990-01-01');
        $gender    = Gender::other();
        $email     = Email::fromString('foo@bar.com');

        $adopter = Adopter::register(
            $id,
            $name,
            $birthdate,
            $gender,
            $email
        );

        $this->adopters()->create($adopter);

        $this->assertPublishedEvent(AdopterRegistered::occur(
            $id,
            $name,
            $email,
            $birthdate,
            $gender
        ));
    }

    public function testPublishesEventsWhenUpdatingAdopter(): void
    {
        $adopter = AdopterMother::registeredExample();

        $this->adopters()->create($adopter);

        $this->eventPublisher()->clear();

        $pet = PetMother::example();

        $adopter->receivePet($pet);

        $this->adopters()->update($adopter);

        $this->assertPublishedEvent(ReceivedPet::occur(
            $adopter->id(),
            $pet
        ));
    }

    public function testFetchesExistingAdopter(): void
    {
        $adopter = AdopterMother::registeredExample();

        $this->adopters()->create($adopter);

        $result = $this->adopters()->get($adopter->id());

        $this->context()::assertEquals($adopter, $result);
    }

    public function testFetchesNotExistentAdopterAndThrows(): void
    {
        $adopter = AdopterMother::registeredExample();
        $otherId = AdopterMother::randomId();

        $this->adopters()->create($adopter);

        $this->expectException(AdopterNotFound::class);

        $this->adopters()->get($otherId);
    }

    public function testUpdatesNotExistentAdopterAndThrows(): void
    {
        $adopter = AdopterMother::registeredExample();

        $this->context()->expectException(AdopterNotFound::class);

        $this->adopters()->update($adopter);
    }

    abstract protected function adopters(): Adopters;
}

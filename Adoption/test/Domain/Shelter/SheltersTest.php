<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Domain\Shelter;

use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Domain\Contact\ContactEmail;
use Sip\Psinder\Adoption\Domain\Shelter\Shelter;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterContactFormAdded;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterId;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterName;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterNotFound;
use Sip\Psinder\Adoption\Domain\Shelter\ShelterRegistered;
use Sip\Psinder\Adoption\Domain\Shelter\Shelters;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsPublishingTest;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\TestCaseAwareTrait;
use Sip\Psinder\SharedKernel\Test\Domain\AddressMother;

trait SheltersTest
{
    use TestCaseAwareTrait;
    use EventsPublishingTest;

    public function testPublishesEventsWhenCreatingShelter() : void
    {
        $id      = new ShelterId(Uuid::uuid4()->toString());
        $name    = ShelterName::fromString('Foo');
        $address = AddressMother::example();
        $email   = Email::fromString('me@foo.com');

        $shelter = Shelter::register(
            $id,
            $name,
            $address,
            $email
        );

        $this->shelters()->create($shelter);

        $this->assertPublishedEvent(ShelterRegistered::occur(
            $id,
            $name,
            $email,
            $address
        ));
    }

    public function testPublishesEventsWhenUpdatingShelter() : void
    {
        $id      = new ShelterId(Uuid::uuid4()->toString());
        $name    = ShelterName::fromString('Foo');
        $address = AddressMother::example();
        $email   = Email::fromString('me@foo.com');

        $shelter = Shelter::register(
            $id,
            $name,
            $address,
            $email
        );

        $this->shelters()->create($shelter);

        $contactForm = ContactEmail::fromEmail(Email::fromString('bar@example.com'));

        $shelter->addContactForm($contactForm);

        $this->shelters()->update($shelter);

        $this->assertPublishedEvent(ShelterContactFormAdded::occur(
            $id,
            $contactForm
        ));
    }

    public function testChecksExistenceOfShelter() : void
    {
        $shelter = ShelterMother::registeredWithRandomId();

        $this->shelters()->create($shelter);

        $result = $this->shelters()->exists($shelter->id());

        $this->context()::assertTrue($result, 'Expected shelter does not exist');
    }

    public function testChecksExistenceOfNotExistentShelter() : void
    {
        $notExistentId = ShelterMother::randomId();
        $result        = $this->shelters()->exists($notExistentId);

        $this->context()::assertFalse($result, 'Expected not existent shelter exist');
    }

    public function testUpdatedExistingShelter() : void
    {
        $id      = new ShelterId(Uuid::uuid4()->toString());
        $name    = ShelterName::fromString('Foo');
        $address = AddressMother::example();
        $email   = Email::fromString('me@foo.com');

        $shelter = Shelter::register(
            $id,
            $name,
            $address,
            $email
        );

        $this->shelters()->create($shelter);

        $shelter->addContactForm(ContactEmail::fromEmail(Email::fromString('bar@example.com')));

        $this->shelters()->update($shelter);

        $result = $this->shelters()->get($id);

        $this->context()::assertEquals($shelter, $result);
    }

    public function testGetsNotExistentShelterAndThrows() : void
    {
        $id = new ShelterId(Uuid::uuid4()->toString());

        $this->context()->expectException(ShelterNotFound::class);

        $this->shelters()->get($id);
    }

    public function testUpdatesNotExistentShelterAndThrows() : void
    {
        $shelter = ShelterMother::registeredWithRandomId();

        $this->context()->expectException(ShelterNotFound::class);

        $this->shelters()->update($shelter);
    }

    abstract protected function shelters() : Shelters;
}

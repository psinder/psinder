<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Shelter;

use Sip\Psinder\Adoption\Domain\Contact\ContactEmail;
use Sip\Psinder\Adoption\Domain\Contact\ContactForm;
use Sip\Psinder\Adoption\Domain\Contact\ContactForms;
use Sip\Psinder\SharedKernel\Domain\Address;
use Sip\Psinder\SharedKernel\Domain\AggregateRoot;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Domain\Event;
use Sip\Psinder\SharedKernel\Domain\EventsPublishingAggregateRoot;

final class Shelter implements AggregateRoot
{
    use EventsPublishingAggregateRoot;

    private ShelterId $id;
    private ShelterName $name;
    private Address $address;
    private ContactForms $contactForms;

    /**
     * @param Event[] $events
     */
    private function __construct(
        ShelterId $id,
        ShelterName $name,
        Address $address,
        ContactForms $contactForms,
        array $events = []
    ) {
        $this->id           = $id;
        $this->name         = $name;
        $this->address      = $address;
        $this->contactForms = $contactForms;
        $this->events       = $events;
    }

    public static function register(
        ShelterId $id,
        ShelterName $name,
        Address $address,
        Email $email
    ) : self {
        return new self(
            $id,
            $name,
            $address,
            ContactForms::fromForms(ContactEmail::fromEmail($email)),
            [ShelterRegistered::occur($id, $name, $email, $address)]
        );
    }

    public function id() : ShelterId
    {
        return $this->id;
    }

    public function name() : ShelterName
    {
        return $this->name;
    }

    public function address() : Address
    {
        return $this->address;
    }

    public function contactForms() : ContactForms
    {
        return $this->contactForms;
    }

    public function addContactForm(ContactForm $contactForm) : void
    {
        $this->contactForms->add($contactForm);

        $this->events[] = ShelterContactFormAdded::occur($this->id, $contactForm);
    }
}

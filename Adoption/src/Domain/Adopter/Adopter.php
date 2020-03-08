<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Adopter;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sip\Psinder\Adoption\Domain\Contact\ContactEmail;
use Sip\Psinder\Adoption\Domain\Contact\ContactForms;
use Sip\Psinder\Adoption\Domain\Pet\Pet;
use Sip\Psinder\SharedKernel\Domain\AggregateRoot;
use Sip\Psinder\SharedKernel\Domain\Birthdate;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Domain\Event;
use Sip\Psinder\SharedKernel\Domain\EventsPublishingAggregateRoot;
use Sip\Psinder\SharedKernel\Domain\Gender;

final class Adopter implements AggregateRoot
{
    use EventsPublishingAggregateRoot;

    private AdopterId $id;
    private AdopterName $name;
    private Birthdate $birthdate;
    private Gender $gender;
    /** @var Collection|Pet[] */
    private Collection $pets;
    private ContactForms $contactForms;

    /**
     * @param Pet[]   $pets
     * @param Event[] $events
     */
    private function __construct(
        AdopterId $id,
        AdopterName $name,
        Birthdate $birthdate,
        Gender $gender,
        array $pets,
        ContactForms $contactForms,
        array $events = []
    ) {
        $this->id           = $id;
        $this->name         = $name;
        $this->birthdate    = $birthdate;
        $this->gender       = $gender;
        $this->pets         = new ArrayCollection($pets);
        $this->contactForms = $contactForms;
        $this->events       = $events;
    }

    public static function register(
        AdopterId $id,
        AdopterName $name,
        Birthdate $birthdate,
        Gender $gender,
        Email $email
    ) : self {
        return new self(
            $id,
            $name,
            $birthdate,
            $gender,
            [],
            ContactForms::fromForms(ContactEmail::fromEmail($email)),
            [AdopterRegistered::occur($id, $name, $email, $birthdate, $gender)]
        );
    }

    public function id() : AdopterId
    {
        return $this->id;
    }

    public function name() : AdopterName
    {
        return $this->name;
    }

    public function birthdate() : Birthdate
    {
        return $this->birthdate;
    }

    public function gender() : Gender
    {
        return $this->gender;
    }

    /**
     * @return Pet[]
     */
    public function pets() : array
    {
        return $this->pets->toArray();
    }

    public function contactForms() : ContactForms
    {
        return $this->contactForms;
    }

    public function receivePet(Pet $pet) : void
    {
        $this->pets->add($pet);
        $this->events[] = ReceivedPet::occur($this->id, $pet);
    }
}

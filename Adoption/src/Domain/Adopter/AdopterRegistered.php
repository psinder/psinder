<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Domain\Adopter;

use DateTimeImmutable;
use Sip\Psinder\SharedKernel\Domain\Birthdate;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Domain\Event;
use Sip\Psinder\SharedKernel\Domain\Gender;

final class AdopterRegistered implements Event
{
    private string $id;

    private string $birthdate;

    private string $gender;

    private string $email;

    private string $firstName;

    private string $lastName;

    private DateTimeImmutable $occurredAt;

    public function __construct(
        string $id,
        string $firstName,
        string $lastName,
        string $email,
        string $birthdate,
        string $gender,
        DateTimeImmutable $occurredAt
    ) {
        $this->id         = $id;
        $this->birthdate  = $birthdate;
        $this->gender     = $gender;
        $this->email      = $email;
        $this->firstName  = $firstName;
        $this->lastName   = $lastName;
        $this->occurredAt = $occurredAt;
    }

    public static function occur(
        AdopterId $id,
        AdopterName $name,
        Email $email,
        Birthdate $birthdate,
        Gender $gender
    ) : self {
        return new self(
            $id->toScalar(),
            $name->firstName(),
            $name->lastName(),
            $email->toString(),
            $birthdate->toString(),
            $gender->toString(),
            new DateTimeImmutable()
        );
    }

    public function id() : string
    {
        return $this->id;
    }

    public function firstName() : string
    {
        return $this->firstName;
    }

    public function lastName() : string
    {
        return $this->lastName;
    }

    public function birthdate() : string
    {
        return $this->birthdate;
    }

    public function gender() : string
    {
        return $this->gender;
    }

    public function email() : string
    {
        return $this->email;
    }

    public function occurredAt() : DateTimeImmutable
    {
        return $this->occurredAt;
    }
}

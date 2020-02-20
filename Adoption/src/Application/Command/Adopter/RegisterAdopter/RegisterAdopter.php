<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\Adopter\RegisterAdopter;

use Sip\Psinder\SharedKernel\Application\Command\Command;

final class RegisterAdopter implements Command
{
    /** @var string */
    private $firstName;
    /** @var string */
    private $lastName;
    /** @var string */
    private $birthdate;
    /** @var string */
    private $gender;

    /** @var string */
    private $id;

    /** @var string */
    private $email;

    public function __construct(
        string $id,
        string $firstName,
        string $lastName,
        string $email,
        string $birthdate,
        string $gender
    ) {
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->birthdate = $birthdate;
        $this->gender    = $gender;
        $this->id        = $id;
        $this->email     = $email;
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
}

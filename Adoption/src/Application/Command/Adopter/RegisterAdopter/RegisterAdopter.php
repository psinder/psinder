<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\Adopter\RegisterAdopter;

use Sip\Psinder\SharedKernel\Application\Command\Command;

final class RegisterAdopter implements Command
{
    private string $id;
    private string $firstName;
    private string $lastName;
    private string $birthdate;
    private string $gender;
    private string $email;
    private string $password;

    public function __construct(
        string $id,
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $birthdate,
        string $gender
    ) {
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->birthdate = $birthdate;
        $this->gender    = $gender;
        $this->id        = $id;
        $this->email     = $email;
        $this->password  = $password;
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

    public function password() : string
    {
        return $this->password;
    }

    public function email() : string
    {
        return $this->email;
    }
}

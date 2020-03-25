<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\UI\Http\Adopter;

final class PostRegisterAdopterRequest
{
    public string $email;
    public string $password;
    public string $firstName;
    public string $lastName;
    public string $birthDate;
    public string $gender;

    public function __construct(
        string $email,
        string $password,
        string $firstName,
        string $lastName,
        string $birthDate,
        string $gender
    ) {
        $this->email     = $email;
        $this->password  = $password;
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->birthDate = $birthDate;
        $this->gender    = $gender;
    }
}

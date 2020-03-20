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
}

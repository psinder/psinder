<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\UI\Http\Shelter;

final class PostRegisterShelterRequest
{
    public string $email;
    public string $password;
    public string $name;
    public string $addressStreet;
    public string $addressNumber;
    public string $addressPostalCode;
    public string $addressCity;
}

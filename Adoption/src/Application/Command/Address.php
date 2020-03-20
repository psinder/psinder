<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command;

final class Address
{
    private string $street;
    private string $number;
    private string $postalCode;
    private string $city;

    public function __construct(
        string $street,
        string $number,
        string $postalCode,
        string $city
    ) {
        $this->street     = $street;
        $this->number     = $number;
        $this->postalCode = $postalCode;
        $this->city       = $city;
    }

    public function street() : string
    {
        return $this->street;
    }

    public function number() : string
    {
        return $this->number;
    }

    public function postalCode() : string
    {
        return $this->postalCode;
    }

    public function city() : string
    {
        return $this->city;
    }
}

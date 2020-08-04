<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Domain;

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

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    /** @return string[] */
    public function toArray(): array
    {
        return [
            'street' => $this->street,
            'number' => $this->number,
            'postalCode' => $this->postalCode,
            'city' => $this->city,
        ];
    }
}

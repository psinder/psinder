<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command\Shelter\RegisterShelter;

use Sip\Psinder\Adoption\Application\Command\Address;
use Sip\Psinder\SharedKernel\Application\Command\Command;

final class RegisterShelter implements Command
{
    private string $id;

    private string $name;

    private Address $address;

    private string $email;

    public function __construct(string $id, string $name, Address $address, string $email)
    {
        $this->id      = $id;
        $this->name    = $name;
        $this->address = $address;
        $this->email   = $email;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function address() : Address
    {
        return $this->address;
    }

    public function email() : string
    {
        return $this->email;
    }
}

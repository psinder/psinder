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
    private string $password;

    public function __construct(string $id, string $name, Address $address, string $email, string $password)
    {
        $this->id       = $id;
        $this->name     = $name;
        $this->address  = $address;
        $this->email    = $email;
        $this->password = $password;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function address(): Address
    {
        return $this->address;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}

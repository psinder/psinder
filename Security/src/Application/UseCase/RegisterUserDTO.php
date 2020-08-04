<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Application\UseCase;

final class RegisterUserDTO
{
    private string $id;
    private string $email;
    private string $password;
    /** @var  string[] */
    private array $roles;

    /**
     * @param string[] $roles
     */
    public function __construct(string $id, array $roles, string $email, string $password)
    {
        $this->id       = $id;
        $this->email    = $email;
        $this->password = $password;
        $this->roles    = $roles;
    }

    public function id(): string
    {
        return $this->id;
    }

    /** @return string[] */
    public function roles(): array
    {
        return $this->roles;
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

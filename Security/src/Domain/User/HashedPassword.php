<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Domain\User;

final class HashedPassword
{
    private string $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function equals(self $otherPassword): bool
    {
        return $this->password === $otherPassword->password;
    }

    public function toString(): string
    {
        return $this->password;
    }
}

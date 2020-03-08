<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Domain\User;

use Assert\Assertion;

final class Role
{
    private const ROLE_SHELTER = 'shelter';
    private const ROLE_ADOPTER = 'adopter';

    private const ROLES = [
        self::ROLE_ADOPTER,
        self::ROLE_SHELTER,
    ];

    private string $identifier;

    private function __construct(string $identifier)
    {
        Assertion::inArray($identifier, self::ROLES);

        $this->identifier = $identifier;
    }

    public static function fromString(string $identifier) : self
    {
        return new self($identifier);
    }

    public function identifier() : string
    {
        return $this->identifier;
    }

    public function equals(Role $role) : bool
    {
        return $this->identifier === $role->identifier;
    }
}

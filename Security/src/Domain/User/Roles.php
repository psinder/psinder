<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Domain\User;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

use function Functional\map;
use function Functional\some;

/**
 * @implements IteratorAggregate<Role>
 */
final class Roles implements IteratorAggregate
{
    /** @var Role[] */
    private array $roles;

    /** @param Role[] $roles */
    public function __construct(array $roles)
    {
        $this->roles = $roles;
    }

    /** @param string[] $roles */
    public static function fromStringArray(array $roles): self
    {
        return new self(map($roles, static fn ($role) => Role::fromString($role)));
    }

    public function exists(Role $role): bool
    {
        return some($this->roles, static fn (Role $existingRole): bool => $existingRole->equals($role));
    }

    /** @return string[] */
    public function toScalarArray(): array
    {
        return map($this->roles, static fn (Role $role): string => $role->identifier());
    }

    /**
     * @return Role[]
     *
     * @phpstan-return Traversable<mixed, Role>
     */
    public function getIterator(): iterable
    {
        return new ArrayIterator($this->roles);
    }
}

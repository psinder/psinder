<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Infrastructure\Authentication;

use Mezzio\Authentication\UserInterface;
use Sip\Psinder\Security\Domain\User\User;

final class AuthenticationUser implements UserInterface
{
    /** @var string */
    private $identity;

    /** @var string[] */
    private $roles;

    /** @var mixed[] */
    private $details;

    /**
     * @param string[] $roles
     * @param mixed[]  $details
     */
    public function __construct(string $identity, array $roles, array $details)
    {
        $this->identity = $identity;
        $this->roles    = $roles;
        $this->details  = $details;
    }

    public static function fromUser(User $user) : self
    {
        return new self(
            $user->id()->toScalar(),
            $user->roles()->toScalarArray(),
            []
        );
    }

    public function getIdentity() : string
    {
        return $this->identity;
    }

    /**
     * @return string[]
     */
    public function getRoles() : iterable
    {
        return $this->roles;
    }

    /**
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function getDetail(string $name, $default = null)
    {
        return $this->details[$name] ?? $default;
    }

    /**
     * @return mixed[]
     */
    public function getDetails() : array
    {
        return $this->details;
    }
}

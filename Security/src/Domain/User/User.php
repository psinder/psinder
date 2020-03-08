<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Domain\User;

use Sip\Psinder\SharedKernel\Domain\AggregateRoot;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Domain\EventsPublishingAggregateRoot;
use Sip\Psinder\SharedKernel\Domain\Identity\Identity;

final class User implements AggregateRoot
{
    use EventsPublishingAggregateRoot;

    private UserId $id;

    private Credentials $credentials;

    private Roles $roles;

    private function __construct(UserId $id, Roles $roles, Credentials $credentials)
    {
        $this->id          = $id;
        $this->credentials = $credentials;
        $this->roles       = $roles;
    }

    /**
     * @param mixed[] $details
     */
    public static function register(UserId $id, Roles $roles, Credentials $credentials, array $details) : self
    {
        $instance = new self($id, $roles, $credentials);

        $instance->events[] = UserRegistered::occur($id, $credentials->email(), $roles, $details);

        return $instance;
    }

    /**
     * @return UserId
     */
    public function id() : Identity
    {
        return $this->id;
    }

    public function roles() : Roles
    {
        return $this->roles;
    }

    public function email() : Email
    {
        return $this->credentials->email();
    }

    public function matchesCredentials(Credentials $credentials) : bool
    {
        return $this->credentials->equals($credentials);
    }
}

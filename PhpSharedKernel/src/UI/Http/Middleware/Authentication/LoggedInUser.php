<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\UI\Http\Middleware\Authentication;

final class LoggedInUser implements AuthenticatedUser
{
    private string $userId;
    /** @var string[] */
    private array $roles;

    /** @param string[] $roles */
    public function __construct(string $userId, array $roles)
    {
        $this->userId = $userId;
        $this->roles  = $roles;
    }

    public function userId() : ?string
    {
        return $this->userId;
    }

    /** @return string[] */
    public function roles() : array
    {
        return $this->roles;
    }

    public function isLoggedIn() : bool
    {
        return true;
    }
}

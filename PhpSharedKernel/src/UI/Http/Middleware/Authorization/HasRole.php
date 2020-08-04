<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\UI\Http\Middleware\Authorization;

use Sip\Psinder\SharedKernel\UI\Http\Middleware\Authentication\AuthenticatedUser;

use function in_array;

final class HasRole implements AuthorizationRule
{
    private string $role;

    public function __construct(string $role)
    {
        $this->role = $role;
    }

    public function isAuthorized(AuthenticatedUser $user): bool
    {
        return in_array($this->role, $user->roles(), true);
    }
}

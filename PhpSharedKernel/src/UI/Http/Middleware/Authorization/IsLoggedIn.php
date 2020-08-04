<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\UI\Http\Middleware\Authorization;

use Sip\Psinder\SharedKernel\UI\Http\Middleware\Authentication\AuthenticatedUser;

final class IsLoggedIn implements AuthorizationRule
{
    public function isAuthorized(AuthenticatedUser $user): bool
    {
        return $user->isLoggedIn();
    }
}

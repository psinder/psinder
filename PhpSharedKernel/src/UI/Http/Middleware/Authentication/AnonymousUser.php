<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\UI\Http\Middleware\Authentication;

final class AnonymousUser implements AuthenticatedUser
{
    public function userId(): ?string
    {
        return null;
    }

    /** @return string[] */
    public function roles(): array
    {
        return [];
    }

    public function isLoggedIn(): bool
    {
        return false;
    }
}

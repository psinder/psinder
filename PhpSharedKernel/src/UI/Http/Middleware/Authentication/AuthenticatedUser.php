<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\UI\Http\Middleware\Authentication;

interface AuthenticatedUser
{
    public function isLoggedIn(): bool;

    public function userId(): ?string;

    /** @return string[] */
    public function roles(): array;
}

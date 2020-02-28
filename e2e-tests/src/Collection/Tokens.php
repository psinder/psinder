<?php

declare(strict_types = 1);

namespace Sip\Psinder\E2E\Collection;

interface Tokens
{
    public function retrieve( string $email, string $password ): ?string;
}
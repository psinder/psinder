<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Application;

use Sip\Psinder\Security\Domain\User\HashedPassword;

interface PasswordHasher
{
    public function hash(string $plainPassword, string $salt): HashedPassword;
}

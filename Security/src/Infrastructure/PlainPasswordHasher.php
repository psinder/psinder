<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Infrastructure;

use Sip\Psinder\Security\Application\PasswordHasher;
use Sip\Psinder\Security\Domain\User\HashedPassword;

final class PlainPasswordHasher implements PasswordHasher
{
    public function encode(string $plainPassword, string $salt) : HashedPassword
    {
        return new HashedPassword($plainPassword);
    }
}

<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Infrastructure;

use Sip\Psinder\Security\Application\PasswordHasher;
use Sip\Psinder\Security\Domain\User\HashedPassword;
use function hash;

final class Sha256PasswordHasher implements PasswordHasher
{
    public function encode(string $plainPassword, string $salt) : HashedPassword
    {
        return new HashedPassword(
            hash('sha256', $plainPassword . $salt)
        );
    }
}

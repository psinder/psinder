<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Infrastructure;

use Sip\Psinder\Security\Application\PasswordHasher;
use Sip\Psinder\Security\Domain\User\EncodedPassword;

final class PlainPasswordHasher implements PasswordHasher
{
    public function encode(string $plainPassword, string $salt) : EncodedPassword
    {
        return new EncodedPassword($plainPassword);
    }
}

<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Application;

use Sip\Psinder\Security\Domain\User\EncodedPassword;

interface PasswordHasher
{
    public function encode(string $plainPassword, string $salt) : EncodedPassword;
}

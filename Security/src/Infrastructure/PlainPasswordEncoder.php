<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Infrastructure;

use Sip\Psinder\Security\Application\PasswordEncoder;
use Sip\Psinder\Security\Domain\User\EncodedPassword;

final class PlainPasswordEncoder implements PasswordEncoder
{
    public function encode(string $plainPassword) : EncodedPassword
    {
        return new EncodedPassword($plainPassword);
    }
}

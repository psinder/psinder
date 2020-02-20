<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Application;

use Sip\Psinder\Security\Domain\User\EncodedPassword;

interface PasswordEncoder
{
    public function encode(string $plainPassword) : EncodedPassword;
}

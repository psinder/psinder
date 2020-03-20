<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Command;

interface UserRegisterer
{
    /** @param string[] $roles */
    public function register(string $id, string $email, string $plainPassword, array $roles) : void;
}

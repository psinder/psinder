<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Application;

use Sip\Psinder\Adoption\Application\Command\UserRegisterer;

final class UserRegistererStub implements UserRegisterer
{
    /** @param string[] $roles */
    public function register(string $id, string $email, string $plainPassword, array $roles) : void
    {
    }
}

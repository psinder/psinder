<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Test\Domain\User;

use Ramsey\Uuid\Uuid;
use Sip\Psinder\Security\Domain\User\Credentials;
use Sip\Psinder\Security\Domain\User\HashedPassword;
use Sip\Psinder\Security\Domain\User\Roles;
use Sip\Psinder\Security\Domain\User\User;
use Sip\Psinder\Security\Domain\User\UserId;
use Sip\Psinder\SharedKernel\Domain\Email;

final class UserMother
{
    public static function randomId() : UserId
    {
        return new UserId(Uuid::uuid4()->toString());
    }

    public static function example() : User
    {
        return User::register(
            self::randomId(),
            new Roles([]),
            Credentials::fromEmailAndPassword(
                Email::fromString('foo@example.com'),
                new HashedPassword('foobar')
            ),
            []
        );
    }
}

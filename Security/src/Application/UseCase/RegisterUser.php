<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Application\UseCase;

use Sip\Psinder\Security\Application\PasswordHasher;
use Sip\Psinder\Security\Domain\User\Credentials;
use Sip\Psinder\Security\Domain\User\Role;
use Sip\Psinder\Security\Domain\User\Roles;
use Sip\Psinder\Security\Domain\User\User;
use Sip\Psinder\Security\Domain\User\UserId;
use Sip\Psinder\Security\Domain\User\Users;
use Sip\Psinder\SharedKernel\Domain\Email;

final class RegisterUser
{
    /** @var Users */
    private $users;

    /** @var PasswordHasher */
    private $encoder;

    public function __construct(Users $accounts, PasswordHasher $encoder)
    {
        $this->users   = $accounts;
        $this->encoder = $encoder;
    }

    public function handle(RegisterUserDTO $dto) : void
    {
        $user = User::register(
            new UserId($dto->id()),
            Roles::fromArray([Role::fromString($dto->type())]),
            Credentials::fromEmailAndPassword(
                Email::fromString($dto->email()),
                $this->encoder->encode($dto->password(), $dto->id())
            ),
            $dto->context()
        );

        $this->users->add($user);
    }
}

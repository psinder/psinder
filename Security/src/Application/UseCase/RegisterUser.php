<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Application\UseCase;

use Sip\Psinder\Security\Application\PasswordHasher;
use Sip\Psinder\Security\Domain\User\Credentials;
use Sip\Psinder\Security\Domain\User\Roles;
use Sip\Psinder\Security\Domain\User\User;
use Sip\Psinder\Security\Domain\User\UserId;
use Sip\Psinder\Security\Domain\User\Users;
use Sip\Psinder\SharedKernel\Domain\Email;

final class RegisterUser
{
    private Users $users;
    private PasswordHasher $hasher;

    public function __construct(Users $accounts, PasswordHasher $hasher)
    {
        $this->users  = $accounts;
        $this->hasher = $hasher;
    }

    public function handle(RegisterUserDTO $dto): void
    {
        $user = User::register(
            new UserId($dto->id()),
            Roles::fromStringArray($dto->roles()),
            Credentials::fromEmailAndPassword(
                Email::fromString($dto->email()),
                $this->hasher->hash($dto->password(), $dto->id())
            )
        );

        $this->users->add($user);
    }
}

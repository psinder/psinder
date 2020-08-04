<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Application\UseCase;

use Sip\Psinder\Security\Application\PasswordHasher;
use Sip\Psinder\Security\Domain\User\Credentials;
use Sip\Psinder\Security\Domain\User\InvalidCredentials;
use Sip\Psinder\Security\Domain\User\User;
use Sip\Psinder\Security\Domain\User\Users;
use Sip\Psinder\SharedKernel\Domain\Email;

final class LoginUser
{
    private Users $users;

    private PasswordHasher $passwordHasher;

    public function __construct(Users $users, PasswordHasher $passwordEncoder)
    {
        $this->users          = $users;
        $this->passwordHasher = $passwordEncoder;
    }

    public function handle(LoginUserDTO $dto): User
    {
        $email = Email::fromString($dto->email());
        $user  = $this->users->forEmail($email);

        $credentials = Credentials::fromEmailAndPassword(
            $email,
            $this->passwordHasher->hash($dto->password(), $user->id()->toScalar())
        );

        if (! $user->matchesCredentials($credentials)) {
            throw InvalidCredentials::forCredentials($credentials);
        }

        return $user;
    }
}

<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Application\UseCase;

use Sip\Psinder\Security\Application\PasswordHasher;
use Sip\Psinder\Security\Domain\User\Credentials;
use Sip\Psinder\Security\Domain\User\InvalidCredentials;
use Sip\Psinder\Security\Domain\User\User;
use Sip\Psinder\Security\Domain\User\UserNotFound;
use Sip\Psinder\Security\Domain\User\Users;
use Sip\Psinder\SharedKernel\Domain\Email;

final class LoginUser
{
    /** @var Users */
    private $users;

    /** @var PasswordHasher */
    private $passwordEncoder;

    public function __construct(Users $users, PasswordHasher $passwordEncoder)
    {
        $this->users           = $users;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function handle(LoginUserDTO $dto) : User
    {
        $email = Email::fromString($dto->email());
        $user = $this->users->forEmail($email);

        $credentials = Credentials::fromEmailAndPassword(
            $email,
            $this->passwordEncoder->encode($dto->password(), $user->id()->toScalar())
        );

        if (!$user->matchesCredentials($credentials)) {
            throw InvalidCredentials::forCredentials($credentials);
        }

        return $user;
    }
}

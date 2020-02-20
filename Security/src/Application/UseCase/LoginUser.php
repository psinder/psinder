<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Application\UseCase;

use Sip\Psinder\Security\Application\PasswordEncoder;
use Sip\Psinder\Security\Domain\User\Credentials;
use Sip\Psinder\Security\Domain\User\User;
use Sip\Psinder\Security\Domain\User\Users;
use Sip\Psinder\SharedKernel\Domain\Email;

final class LoginUser
{
    /** @var Users */
    private $users;

    /** @var PasswordEncoder */
    private $passwordEncoder;

    public function __construct(Users $users, PasswordEncoder $passwordEncoder)
    {
        $this->users           = $users;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function handle(LoginUserDTO $dto) : User
    {
        $credentials = Credentials::fromEmailAndPassword(
            Email::fromString($dto->email()),
            $this->passwordEncoder->encode($dto->password())
        );

        return $this->users->forCredentials($credentials);
    }
}

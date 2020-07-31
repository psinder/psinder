<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Test\Application\UseCase;

use Ramsey\Uuid\Uuid;
use Sip\Psinder\Security\Application\PasswordHasher;
use Sip\Psinder\Security\Application\UseCase\LoginUser;
use Sip\Psinder\Security\Application\UseCase\LoginUserDTO;
use Sip\Psinder\Security\Domain\User\Credentials;
use Sip\Psinder\Security\Domain\User\Role;
use Sip\Psinder\Security\Domain\User\Roles;
use Sip\Psinder\Security\Domain\User\User;
use Sip\Psinder\Security\Domain\User\UserId;
use Sip\Psinder\Security\Domain\User\UserNotFound;
use Sip\Psinder\Security\Domain\User\Users;
use Sip\Psinder\Security\Test\TransactionalTestCase;
use Sip\Psinder\SharedKernel\Domain\Email;

final class LoginUserTest extends TransactionalTestCase
{
    private Users $users;
    private LoginUser $useCase;
    private PasswordHasher $passwordHasher;

    public function setUp() : void
    {
        parent::setUp();

        $this->users          = $this->get(Users::class);
        $this->passwordHasher = $this->get(PasswordHasher::class);
        $this->useCase        = $this->get(LoginUser::class);
    }

    public function testLogsInExistingUserUsingValidCredentials() : void
    {
        $id       = Uuid::uuid4()->toString();
        $email    = 'foo@example.com';
        $password = 'foobar';

        $user = User::register(
            new UserId($id),
            new Roles([Role::fromString('shelter')]),
            Credentials::fromEmailAndPassword(
                Email::fromString($email),
                $this->passwordHasher->hash($password, $id)
            )
        );
        $this->users->add($user);

        $dto = new LoginUserDTO(
            $email,
            $password
        );

        $result = $this->useCase->handle($dto);

        self::assertEquals($user, $result);
    }

    public function testLogsInNotExistentUserAndThrows() : void
    {
        $email    = 'foo@example.com';
        $password = 'foobar';

        $dto = new LoginUserDTO(
            $email,
            $password
        );

        $this->expectException(UserNotFound::class);

        $this->useCase->handle($dto);
    }
}

<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Test\Application\UseCase;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Sip\Psinder\Security\Application\PasswordEncoder;
use Sip\Psinder\Security\Application\UseCase\LoginUser;
use Sip\Psinder\Security\Application\UseCase\LoginUserDTO;
use Sip\Psinder\Security\Domain\User\Credentials;
use Sip\Psinder\Security\Domain\User\Role;
use Sip\Psinder\Security\Domain\User\Roles;
use Sip\Psinder\Security\Domain\User\User;
use Sip\Psinder\Security\Domain\User\UserId;
use Sip\Psinder\Security\Domain\User\UserNotFound;
use Sip\Psinder\Security\Infrastructure\Persistence\InMemory\InMemoryUsers;
use Sip\Psinder\Security\Infrastructure\PlainPasswordEncoder;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Infrastructure\InterceptingEventPublisher;

final class LoginUserTest extends TestCase
{
    /** @var InterceptingEventPublisher */
    private $eventPublisher;

    /** @var InMemoryUsers */
    private $users;

    /** @var LoginUser */
    private $useCase;

    /** @var PasswordEncoder */
    private $passwordEncoder;

    public function setUp() : void
    {
        $this->eventPublisher  = new InterceptingEventPublisher();
        $this->users           = new InMemoryUsers($this->eventPublisher);
        $this->passwordEncoder = new PlainPasswordEncoder();
        $this->useCase         = new LoginUser($this->users, $this->passwordEncoder);
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
                $this->passwordEncoder->encode($password)
            ),
            []
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

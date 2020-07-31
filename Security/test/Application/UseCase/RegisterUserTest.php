<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Test\Application\UseCase;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Sip\Psinder\Security\Application\UseCase\RegisterUser;
use Sip\Psinder\Security\Application\UseCase\RegisterUserDTO;
use Sip\Psinder\Security\Domain\User\Role;
use Sip\Psinder\Security\Domain\User\Roles;
use Sip\Psinder\Security\Domain\User\UserId;
use Sip\Psinder\Security\Domain\User\UserRegistered;
use Sip\Psinder\Security\Domain\User\Users;
use Sip\Psinder\Security\Test\TransactionalTestCase;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsPublishingTest;

final class RegisterUserTest extends TransactionalTestCase
{
    use EventsPublishingTest;

    private Users $users;
    private RegisterUser $useCase;

    public function setUp() : void
    {
        parent::setUp();

        $this->users   = $this->get(Users::class);
        $this->useCase = $this->get(RegisterUser::class);
    }

    public function testRegistersShelterUser() : void
    {
        $id  = Uuid::uuid4()->toString();
        $dto = new RegisterUserDTO(
            $id,
            ['shelter'],
            'foo@example.com',
            'foobar'
        );

        $this->useCase->handle($dto);

        $result = $this->users->get(new UserId($id));

        self::assertEquals($id, $result->id()->toScalar());

        $this->assertPublishedEvents(
            UserRegistered::occur(
                new UserId($id),
                new Email('foo@example.com'),
                new Roles([Role::fromString('shelter')])
            )
        );
    }

    protected function context() : TestCase
    {
        return $this;
    }
}

<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Test\Domain\User;

use Sip\Psinder\Security\Domain\User\Roles;
use Sip\Psinder\Security\Domain\User\UserNotFound;
use Sip\Psinder\Security\Domain\User\UserRegistered;
use Sip\Psinder\Security\Domain\User\Users;
use Sip\Psinder\SharedKernel\Domain\Email;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsPublishingTest;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\TestCaseAwareTrait;

trait UsersTest
{
    use EventsPublishingTest;
    use TestCaseAwareTrait;

    public function testPublishesEventsOfAddedUser() : void
    {
        $accounts = $this->users();
        $account  = UserMother::example();
        $accounts->add($account);

        $this->assertPublishedEvents(
            UserRegistered::occur(
                $account->id(),
                new Email('foo@example.com'),
                new Roles([])
            )
        );
    }

    public function testGetsAddedUser() : void
    {
        $accounts = $this->users();

        $account = UserMother::example();

        $accounts->add($account);

        $result = $accounts->get($account->id());

        $this->context()::assertEquals($account, $result);
    }

    public function testGetsNotExistentUserAndThrows() : void
    {
        $accounts = $this->users();

        $accountId = UserMother::randomId();

        $this->context()->expectException(UserNotFound::class);

        $accounts->get($accountId);
    }

    abstract protected function users() : Users;
}

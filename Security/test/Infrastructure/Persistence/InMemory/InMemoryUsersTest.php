<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Test\Infrastructure\Persistence\InMemory;

use PHPUnit\Framework\TestCase;
use Sip\Psinder\Security\Domain\User\Users;
use Sip\Psinder\Security\Infrastructure\Persistence\InMemory\InMemoryUsers;
use Sip\Psinder\Security\Test\Domain\User\UsersTest;

final class InMemoryUsersTest extends TestCase
{
    use UsersTest;

    /** @var InMemoryUsers */
    private $users;

    public function setUp() : void
    {
        parent::setUp();

        $this->users = new InMemoryUsers($this->eventPublisher());
    }

    protected function users() : Users
    {
        return $this->users;
    }

    protected function context() : TestCase
    {
        return $this;
    }
}

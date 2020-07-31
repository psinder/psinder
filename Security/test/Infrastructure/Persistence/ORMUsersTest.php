<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Test\Infrastructure\Persistence;

use PHPUnit\Framework\TestCase;
use Sip\Psinder\Security\Domain\User\Users;
use Sip\Psinder\Security\Infrastructure\Persistence\ORM\ORMUsers;
use Sip\Psinder\Security\Test\Domain\User\UsersTest;
use Sip\Psinder\Security\Test\TransactionalTestCase;

final class ORMUsersTest extends TransactionalTestCase
{
    use UsersTest;

    /** @var ORMUsers */
    private $users;

    public function setUp() : void
    {
        parent::setUp();

        $this->users = $this->get(ORMUsers::class);
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
